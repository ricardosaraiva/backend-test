# Rejeita uma solicitação de amizade 
Rejeita uma solicitação de amizade em aberto de um usuário.

* **URL**

  /user/:id/invitation

* **Method:**

  `DELETE`

  **URL Params**

   **Required:**
   
   `id=[integer]`


* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 

* **Error Response:**
  * **Code:** 400  <br />
    **Content:** `"Invalid friendship request"`