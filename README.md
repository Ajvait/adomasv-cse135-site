# CSE 135 Site - Adomas Vaitkus

## Homework 1

### Names
Adomas Vaitkus

### Grader Login
Username: grader
Password: UCSD135Grader

### Link to site
https://adomasvcse135.site/

### Deployment Instructions:
This site deploys via GitHub to a DigitalOcean server.
1. Edit files locally
2. Commit + push to GitHub
3. SSH into server
4. Run: `/var/www/adomasvcse135.site/deploy.sh`


### Username/password for site:
Username: grader
Password: GraderUCSD@W26

### Changes to HTML file in DevTools after compression
We enabled Gzip compression using Apache’s mod_deflate module. The DevTools response headers confirm compression is working with Content-Encoding: gzip.

### Server and Site Configuration Summary

I configured HAProxy as the front-facing server to properly obscure the HTTP `Server` header, since this cannot be reliably done using Apache alone. Apache was kept to serve the website content from `/var/www/adomasvcse135.site` but moved to an internal port, while Nginx was used as an internal reverse proxy to maintain routing flexibility. HAProxy was configured to terminate HTTPS using the existing SSL certificate, redirect all HTTP traffic to HTTPS, and remove any backend `Server` headers before setting a custom value of `Server: CSE135 Server` on all responses. I was able to significantly modify the server identity while preserving HTTPS functionality.

## Homework 2

### Link to site
https://adomasvcse135.site/

### Decision for free choice
For the third analytics approach, I evaluated several third-party analytics platforms with an emphasis on simplicity, privacy, and ease of deployment on a static, multi-page website. The first option considered was Umami, a privacy-focused analytics platform that provides page view and referrer tracking using a lightweight script. Another option was Plausible, which offers similar privacy-friendly analytics but requires a paid subscription after a short trial period which I decided was not what I wanted for this homework. A third option evaluated was Matomo, which is feature-rich and open-source but seemed significantly more complex to configure and maintain, especially when self-hosting on a small server. These tools were compared based on setup complexity, cost, data transparency, and how easily analytics traffic could be verified using browser developer tools.

Ultimately, I chose Umami because it offered the best balance of simplicity and functionality while remaining completely free when self-hosted. Integration required only a single script tag added to site pages, and analytics requests were clearly visible in the browser network panel, making verification straightforward. Compared to Plausible, Umami avoided subscription costs, and compared to Matomo, it required far less configuration and overhead. While Umami provides fewer advanced analytics features, it was well-suited for evaluating basic site usage and fulfilled the project requirements efficiently without introducing unnecessary complexity.

### Team members
Adomas Vaitkus

### Grader logins
Username: grader
Password: GraderUCSD@W26

#### For the server:

Username: grader
Password: UCSD135Grader

#### IP Address:
104.248.78.132

## Homework 3
Only additional piece of information is,
SQL user: analytics
SQL password: CSE135pass!
