# TIKET API
Information :
Framework : slim framework
Database file: tiket.sql

# endpoint | /event/create | Method : POST |
## Payload
{
	"nm_event" : "asdasdas",
	"id_location" : "1",
	"start_schedule" : "2019-01-02 11:05:17",
	"end_schedule" : "2020-01-02 11:05:17",
	"id_tiket" : "2",
	"id_customer" : "1"
}
## Response
- Success
{
    "status": "Ok"
}

- Failure
{
    "status": "Error"
}


# endpoint | /event/getinfo | Method : POST |
## Payload
{
	"id_event" : "7",
	"id_customer" : "1"
}
## Response
- Success
{
    "status": "Ok",
    "events": "result"
}

- Failure
{
    "status": "Error",
    "events": "result"
}


# endpoint | /event/ticket/create | Method : POST |
## Payload 
{
	"nm_tiket" : "TIKET PREMIUM TULUS 2",
	"price" : "1000000",
	"quota" : "100",
	"id_event" : "1",
	"id_customer" : "1"
}

## Response
- Success
{
    "status": "Ok"
}

- Failure
{
    "status": "Error"
}


# endpoint | /transaction/purchase | Method : POST |
## Payload 
[
{
	"source_event" : "1",
	"nm_transaction" : "#order00001",
	"id_customer" : "1",
	"id_event" : "1",
	"id_tiket" : "2",
	"qty"      : "4"
},
{
	"source_event" : "1",
	"nm_transaction" : "#order00001",
	"id_customer" : "1",
	"id_event" : "1",
	"id_tiket" : "2",
	"qty"      : "3"
}
]

## Response
- Success
{
    "status": "Ok"
}

- Failure
{
    "status": "Error"
}

- Failure if quota is less than 1
{
    "status": "Error",
    "transactions": "Tiket Sold Out"
}

- Failure if purchase ticket within not same event
{
    "status": "Error",
    "transactions": "Event not authenticate"
}


