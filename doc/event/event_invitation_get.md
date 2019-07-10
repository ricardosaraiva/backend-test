# Lista os convites de eventos: (abertos, aceitos e cancelados)
Retorna uma lista de eventos que o usuario recebeu convite de acordo com o filtro 

* **URL**

  /user/invitation/:status

* **Method:**

  `GET`


  **URL Params**

   **Required:**
   
   `status=[string]('accept' , 'open', 'reject')`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
    
    `[
		{
			"id": 1,
			"name": "xxxx",
			"description": "xxxxxx xxxx",
			"date": "0000-00-00 00:00:00",
			"city": "xxxx",
			"state": "XX",
			"address": "xxxx, xxx",
			"cancel": false
		}
    ]`
