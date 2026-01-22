# CSE 135 Site - Adomas Vaitkus

## Homework 1

### Deployment Instructions:
This site deploys via GitHub to a DigitalOcean server.
1. Edit files locally
2. Commit + push to GitHub
3. SSH into server
4. Run: `/var/www/adomasvcse135.site/deploy.sh`

### Changes to HTML file in DevTools after compression
We enabled Gzip compression using Apache’s mod_deflate module. The DevTools response headers confirm compression is working with Content-Encoding: gzip.

### Server and Site Configuration Summary

I configured HAProxy as the front-facing server to properly obscure the HTTP `Server` header, since this cannot be reliably done using Apache alone. Apache was kept to serve the website content from `/var/www/adomasvcse135.site` but moved to an internal port, while Nginx was used as an internal reverse proxy to maintain routing flexibility. HAProxy was configured to terminate HTTPS using the existing SSL certificate, redirect all HTTP traffic to HTTPS, and remove any backend `Server` headers before setting a custom value of `Server: CSE135 Server` on all responses. I was able to significantly modify the server identity while preserving HTTPS functionality.
