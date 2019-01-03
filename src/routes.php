<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->post("/event/create", function (Request $request, Response $response){ 
	$new_event = $request->getParsedBody(); 
	$sql1 = "INSERT INTO event(nm_event, id_location, start_schedule, end_schedule) VALUE (:nm_event, :id_location, :start_schedule,:end_schedule)"; 
	$stmt = $this->db->prepare($sql1); 
	$stmt->bindValue( ":nm_event", $new_event["nm_event"], PDO::PARAM_STR );
	$stmt->bindValue( ":id_location", $new_event["id_location"], PDO::PARAM_INT );
	$stmt->bindValue( ":start_schedule", $new_event["start_schedule"], PDO::PARAM_STR );
	$stmt->bindValue( ":end_schedule", $new_event["end_schedule"], PDO::PARAM_STR );
	$execute = $stmt->execute();
	$last_id = $this->db->lastInsertId();

	$sql2 = "INSERT INTO events(id_event,id_tiket,id_customer) VALUE (:id_event,:id_tiket,:id_customer)"; 
	$stmt2 = $this->db->prepare($sql2); 
	$stmt2->bindValue( ":id_event", $last_id, PDO::PARAM_INT );
	$stmt2->bindValue( ":id_customer", $new_event["id_customer"], PDO::PARAM_INT );
	$stmt2->bindValue( ":id_tiket", $new_event["id_tiket"], PDO::PARAM_INT );
	
	 if($stmt2->execute())
	       return $response->withJson(["status" => "Ok"], 200);
	    
	    return $response->withJson(["status" => "Error"], 200);
});


$app->post("/event/getinfo", function (Request $request, Response $response){
	$new_event = $request->getParsedBody(); 
	$sql = "SELECT a.id,e.nm_event,b.nm_location,d.nm_tiket,c.nm_customer,e.start_schedule,e.end_schedule
	FROM events a
	INNER JOIN event e ON e.id = a.id_event
	INNER JOIN locations b ON b.id = e.id_location 
	INNER JOIN customers c ON c.id = a.id_customer
	INNER JOIN tikets d ON d.id = a.id_tiket
	WHERE e.id = :id_event and a.id_customer = :id_customer"; 
	$stmt = $this->db->prepare($sql);
	$stmt->bindValue( ":id_event", $new_event["id_event"], PDO::PARAM_STR );
	$stmt->bindValue( ":id_customer", $new_event["id_customer"], PDO::PARAM_INT );
	$stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "Ok", "events" => $result], 200);
});

$app->post("/location/create", function (Request $request, Response $response){ 
	$new_event = $request->getParsedBody(); 
	$sql1 = "INSERT INTO locations(nm_location) VALUE (:nm_location)"; 
	$stmt = $this->db->prepare($sql1); 
	$stmt->bindValue( ":nm_location", $new_event["nm_location"], PDO::PARAM_STR );

	 if($stmt->execute())
	       return $response->withJson(["status" => "Ok"], 200);
	    
	    return $response->withJson(["status" => "Error"], 200);
});

$app->post("/event/ticket/create", function (Request $request, Response $response){ 
	$new_event = $request->getParsedBody(); 
	$sql1 = "INSERT INTO tikets(nm_tiket, price, quota, id_event) VALUE (:nm_tiket, :price, :quota,:id_event)"; 
	$stmt = $this->db->prepare($sql1); 
	$stmt->bindValue( ":nm_tiket", $new_event["nm_tiket"], PDO::PARAM_STR );
	$stmt->bindValue( ":price", $new_event["price"], PDO::PARAM_INT );
	$stmt->bindValue( ":quota", $new_event["quota"], PDO::PARAM_STR );
	$stmt->bindValue( ":id_event", $new_event["id_event"], PDO::PARAM_STR );

	 if($stmt->execute())
	       return $response->withJson(["status" => "Ok"], 200);
	    
	    return $response->withJson(["status" => "Error"], 200);
});

$app->post("/transaction/purchase", function (Request $request, Response $response){ 
	$new_event = $request->getParsedBody();
	$sql1 = "INSERT INTO transactions(nm_transaction, id_customer, id_event, id_tiket) VALUE (:nm_transaction, :id_customer, :id_event,:id_tiket)"; 
	$stmt = $this->db->prepare($sql1); 
	$stmt->bindValue( ":nm_transaction", $new_event["nm_transaction"], PDO::PARAM_STR );
	$stmt->bindValue( ":id_customer", $new_event["id_customer"], PDO::PARAM_INT );
	$stmt->bindValue( ":id_event", $new_event["id_event"], PDO::PARAM_STR );
	$stmt->bindValue( ":id_tiket", $new_event["id_tiket"], PDO::PARAM_STR );

	 if($stmt->execute())
	       return $response->withJson(["status" => "Ok"], 200);
	    
	    return $response->withJson(["status" => "Error"], 200);
});

$app->post("/transaction/get_info", function (Request $request, Response $response){
	$new_event = $request->getParsedBody(); 
	$sql = "SELECT a.id,a.nm_transaction,b.nm_customer,c.nm_event,d.nm_tiket,c.start_schedule,c.end_schedule
	FROM transactions a
	INNER JOIN customers b ON b.id = a.id_customer
	INNER JOIN event c ON c.id = a.id_event
	INNER JOIN tikets d ON d.id = a.id_tiket
	WHERE a.nm_transaction = :nm_transaction and a.id_customer = :id_customer and a.id_event = :id_event and status = 'process'"; 
	$stmt = $this->db->prepare($sql);
	$stmt->bindValue( ":nm_transaction", $new_event["nm_transaction"], PDO::PARAM_STR );
	$stmt->bindValue( ":id_customer", $new_event["id_customer"], PDO::PARAM_INT );
	$stmt->bindValue( ":id_event", $new_event["id_event"], PDO::PARAM_INT );
	$stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "Ok", "transactions" => $result], 200);
});
