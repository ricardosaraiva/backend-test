# Lista de eventos
Retorna uma lista com eventos paginado com 10 paginas

* **URL**

  /event/:page

* **Method:**

  `GET`
*  **URL Params**

   **Optional:**
   
   `page=[integer]`

   **Query String:**

   `dateStart=[date]`

   `dateEnd=[date]`

   `place=[string]`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{
	"items": "1",
	"itemsPerPage": 10,
	"data": [
		{
			"id": 1,
			"name": "event name",
			"description": "xxxxxx xxxx",
			"date": "0000-00-00 00:00:00",
			"city": "xxxx",
			"state": "XX",
			"address": "xxxx, xxx",
			"cancel": false
		}
}`
