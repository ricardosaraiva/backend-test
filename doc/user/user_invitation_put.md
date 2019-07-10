# Aceita uma solicitação de amizade 
Aceita uma solicitação de amizade em aberto de um usuário.

* **URL**

  /user/:id/invitation/

* **Method:**

  `PUT`

  **URL Params**

   **Required:**
   
   `id=[integer]`


* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 

* **Error Response:**
  * **Code:** 400  <br />
    **Content:** `"Invalid friendship request"`