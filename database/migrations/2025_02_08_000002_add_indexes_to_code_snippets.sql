-- Migration pour ajouter des index supplémentaires à la table code_snippets

-- Index pour optimiser les recherches par titre
CREATE INDEX IF NOT EXISTS idx_title ON code_snippets(title);

-- Index pour optimiser les recherches dans la description
CREATE INDEX IF NOT EXISTS idx_description ON code_snippets USING gin(to_tsvector('french', description));

-- Index composé pour les requêtes avec catégorie et date
CREATE INDEX IF NOT EXISTS idx_category_created_at ON code_snippets(category, created_at DESC);

-- Commentaires sur la table
COMMENT ON TABLE code_snippets IS 'Table stockant les snippets de code partagés par les utilisateurs';
COMMENT ON COLUMN code_snippets.title IS 'Titre descriptif du snippet';
COMMENT ON COLUMN code_snippets.description IS 'Description optionnelle du snippet';
COMMENT ON COLUMN code_snippets.category IS 'Catégorie du code (PHP, HTML, CSS)';
COMMENT ON COLUMN code_snippets.code_content IS 'Contenu du code source';
