# Uncomment the following to prevent the httpoxy vulnerability
# See: https://httpoxy.org/
#<IfModule mod_headers.c>
#    RequestHeader unset Proxy
#</IfModule>

RewriteEngine on
RewriteRule    ^$    webroot/    [L]
RewriteRule    (.*) webroot/$1    [L]

# Environment
setEnv DEBUG 0
