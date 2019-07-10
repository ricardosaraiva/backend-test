# Cria uma evento
Retorna um json com o evento criado

* **URL**

  /event/

* **Method:**

  `POST`
* **Body Params**

        {
            "name": "xxxx",
            "description" : "xxxxx",
            "date" : "xxxx-xx-xx",
            "time" : "xx:xx:xx", 
            "city" : "xxxxxx",
            "state" : "XX",
            "address" : "xxxxx, xxxx"
        }

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
    **Content:** `{ "field": "name", "message": "must contain 3 to 100 characters"}`

* **Code:** 400  <br />
    **Content:** `{"field": "description","message": "must contain 30 characters"}`

* **Code:** 400  <br />
    **Content:** `{ "field": "date", "message": "invalid datetime"}`

* **Code:** 400  <br />
    **Content:** `{ "field": "time", "message": "invalid datetime"}`

* **Code:** 400  <br />
    **Content:** `{ "field": "city", "message": "must contain 3 to 100 characters"}`

* **Code:** 400  <br />
    **Content:** `{ "field": "state", "message": "must contain 2 characters"}`

* **Code:** 400  <br />
    **Content:** `{ "field": "address", "message":  "must contain 3 to 200 characters"}`