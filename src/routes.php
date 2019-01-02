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
	$sql = "SELECT e.id,e.nm_event,b.nm_location,d.nm_tiket,c.nm_customer,e.start_schedule,e.end_schedule
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
