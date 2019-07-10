# Cancela um evento
Retorna um json com o evento cancelado

* **URL**

  /event/:id

* **Method:**

  `DELETE`

  **URL Params**

   **Required:**
   
   `id=[integer]`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
    
        `
		{
			"id": 1,
			"name": "xxx",
			"description": "xxxxxx xxxx",
			"date": "0000-00-00 00:00:00",
			"city": "xxxx",
			"state": "XX",
			"address": "xxxx, xxx",
			"cancel": false
		}`

* **Error Response:**
* **Code:** 400  <br />
    **Content:** `"without permission to edit event"`



   