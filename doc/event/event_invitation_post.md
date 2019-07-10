# Convida um amigo para o evento
Envia uma solicitação para um usuario participar de um evento

* **URL**

  /event/:id/invitation

* **Method:**

  `POST`
* **Body Params**

        {"idUser" : 3}

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
    
    ``


* **Error Response:**

* **Code:** 400  <br />
    **Content:** `"It is not possible to invite yourself"`


* **Code:** 400  <br />
    **Content:** `"Already exists invitation to this user"`
