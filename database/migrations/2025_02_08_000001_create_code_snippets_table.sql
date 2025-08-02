-- Migration pour créer la table des snippets de code (PostgreSQL)

-- Créer le type ENUM pour les catégories
DO $$ 
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'category_type') THEN
        CREATE TYPE category_type AS ENUM ('PHP', 'HTML', 'CSS');
    END IF;
END
$$;

-- Créer la table des snippets de code
CREATE TABLE IF NOT EXISTS code_snippets (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category category_type NOT NULL,
    code_content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Fonction pour mettre à jour updated_at automatiquement
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Trigger pour mettre à jour updated_at
DROP TRIGGER IF EXISTS update_code_snippets_updated_at ON code_snippets;
CREATE TRIGGER update_code_snippets_updated_at
    BEFORE UPDATE ON code_snippets
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

-- Index pour optimiser les recherches par catégorie
CREATE INDEX IF NOT EXISTS idx_category ON code_snippets(category);
CREATE INDEX IF NOT EXISTS idx_created_at ON code_snippets(created_at DESC);
