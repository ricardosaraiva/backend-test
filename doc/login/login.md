# Login no sistema
Retorna um token para ser usado nas conexões da area restrita.

* **URL**

  /login/

* **Method:**

  `POST`

* **Data Params**

        {"email" : "xxxxx@xxxx.com", "password": "xxxxxx"}


* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiUmljYXJkbyBTYXJhaXZhIiwiZW1haWwiOiJ0ZXN0ZUB0ZXN0ZS5jb20iLCJkYXRlIjoiMjAxOS0wNy0wOSAyMjowNzoxMSJ9.IbQoLxm5sUH9T7VaU2kKcRkk2Hcq4eg7lpH6hUMTd9k"`
 
* **Error Response:**
  * **Code:** 400  <br />
    **Content:** `"email or password is invalid"`
