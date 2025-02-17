# Ambiente
- PHP 8.2.12
- Composer version 2.6.5
- Angular 14
- Mysql 5.7
- Laravel 9

# Uteis
- O sistema possui dois repositórios um para o backend e outro para o front.
- O sistema roda de forma embutida, então é foi feito build do angular que salva os arquinos na pasta public do backend laravel, quando fazer o compose do laravel já sobe tudo, mas pode ser feito separado se necessário.

# Observações importantes
 Aplicação depende de um conversor de imagens ImageMagick devido algumas imagens serem muito gandes, teve a necessidade de otimizar o seu tamanho
 convertendo para webp. Isso é um requisito obrigatório, para desabilitar faça isso em codigo.
 
