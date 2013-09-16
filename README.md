# Kisscms

Tipos de página implementadas por arquivos modelo

## Steps

v0.1 REST funcionar - Completa
v0.2 Tipo de pagina conteudo(pagina?) - Completa
v0.21 CRUD de conteudo via REST (baretext editing & viewing - NO HTML) - Completa
v0.3 Sessão de usuários - Completa (Usuário virou um módulo)
v0.4 Inserção de JS e CSS nas peças - Completa
v0.5 Inserção de JS e CSS "globais" nas pages - Completa
v0.6 Mapeamento de paginas (Aliases para paginas) 
v1.0 Renderização de paginas(HTML & CSS & JS)
v1.1 Outros tipos de páginas(recursão de inserção - páginas dentro de outras páginas)
v1.2 Configuração e personalização das páginas via REST 
v2.0 CRUD de outros tipos de página 
v2.1 Permissões de usuários
v2.2 Interface para configuração de páginas
v2.3 Interface para administração geral
v3.0 Rich Text Editor(Nome genérico para permitir possibilidades de interface para CRUD de páginas)

## PAGE

Cada page (0.kiss, 3.kiss...) tem seu tpl em (kiss-pieces/page/tpl) e é moldado segundo suas variáveis


## TODO
- Inserir opção de CSS ou JS como string ou path!

- Criador de .htaccess para o RewriteBase estar sempre correto
- Tratamento de erros $router


## NOTES

Todos pieces, menos page, retornam um JSON com data, html, js e css como itens (talvez até 