The project is a lightweight copy of temp-mail.org for receiving emails on temporary account. 
Using **Slim framework and Websockets**.

Run project using Docker:

`docker-compose up -d`

### For test send email to configured server, use endpoint:
**{PROJECT_PATH}**/sendmail/**{email}**?text=**{text}**

Fox example (if you're using Docker):
http://localhost:8080/sendmail/admin@admin.test?text=test%20text
