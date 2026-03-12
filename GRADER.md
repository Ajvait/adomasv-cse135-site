# GRADER.md

## Login Credentials
| Role | Username | Password |
|-----|------|------|
| Super Admin | admin | admin123 |
| Analyst | sam | sam123 |
| Viewer | viewer | viewer123 |

## Suggested Grading Flow

Go to https://adomasvcse135.site/analytics/login.php and do the following:
1. Login as viewer:viewer123
2. Attempt to access **reports**
3. Click "Export Report to PDF button and check for HTML download
4. Login as sam:sam123
5. Access **charts**
6. Login as admin:admin123
7. Access **manage users**
8. Create the user test:test123 as the type viewer
9. Login as test:test123
10. Attempt to access **reports**
11. Login as admin:admin123
12. Access **manage users**
13. Delete the user test:test123
14. Attempt to login as the user test:test123

## Concerns
I was unable to figure out how to determine whether JS was enabled on the user's end for the collector.js portion so I just set it to true since I thought it would be likely they would have JS enabled if they are able to load the page properly and continue to navigate with statistically significant  mouse movements, clicks, etc.

As far as I know I have fulfilled all other requirements fully.