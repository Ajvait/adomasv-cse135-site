# GRADER.md

## Bullet 1

### Login Credentials
| Role | Username | Password |
|-----|------|------|
| Super Admin | admin | admin123 |
| Analyst | sam | sam123 |
| Viewer | viewer | viewer123 |

Suggested Grading Flow

1. Login as viewer:viewer123
2. Attempt to access **reports**
3. Login as sam:sam123
4. Access **charts**
6. Login as admin:admin123
7. Access **manage users**
8. Create the user test:test123 as the type viewer
9. Login as test:test123
10. Attempt to access **reports**
11. Login as admin:admin123
12. Access **manage users**
13. Delete the user test:test123
14. Attempt to login as the user test:test123