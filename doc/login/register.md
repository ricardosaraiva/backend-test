# Registro de usuário
Retorna um json com um usuário.

* **URL**

  /register/

* **Method:**

  `POST`

* **Body Params**

  Os campos * são obrigatórios

  O Content-Type deve ser multipart/form-data pois tera que enviar um arquivo.
  
  - *name `text`
  - *email `text`
  - *password `text`
  - *city `text`
  - *state `text`
  - *bio `text`
  - picture `arquivo`


* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{ "id": 1, "name": "name", "email": "email@teste.com", "bio": "xxxxx", "picture":  e6b7d594a37830c7cd60c58d6785126b.jpeg", "city": "xxxx", "state": "xxxx" }`
 
* **Error Response:**
  * **Code:** 400  <br />
    **Content:** `{ "field": "name", "message": "must contain 3 to 100 characters"}`
  
  * **Code:** 400  <br />
    **Content:** `{ "field": "email", "message":  "contains an invalid value"}`    
  
  * **Code:** 400  <br />
    **Content:** `{ "field": "password", "message": "must contain 6 to 100 characters"}`

  * **Code:** 400  <br />
    **Content:** `{ "field": "city", "message": "must contain 3 to 100 characters"}`

  * **Code:** 400  <br />
    **Content:** `{ "field": "state", "message": "must contain 2 characters"}`

  * **Code:** 400  <br />
    **Content:** `"E-mail is registred"`

  * **Code:** 400  <br />
    **Content:** `"invalid picture"`
