<?php
include('../DBconfig.php');

if (isset($_POST['delete_btn'])) {
    $id = $_POST['delete_id'];
    
    try {
        $verbinding->beginTransaction();
        
        // Update 'userID' to NULL in the 'houses' table for the houses associated with the user being deleted
        $updateHousesQuery = "UPDATE house SET userID = NULL WHERE userID = :id";
        $stmtUpdateHouses = $verbinding->prepare($updateHousesQuery);
        $stmtUpdateHouses->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtUpdateHouses->execute();
        
        // Delete the user from the 'users' table
        $deleteUserQuery = "DELETE FROM users WHERE userID = :id";
        $stmtDeleteUser = $verbinding->prepare($deleteUserQuery);
        $stmtDeleteUser->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Execute the query to delete the user
        $query_run = $stmtDeleteUser->execute();
        
        if ($query_run) {
            $verbinding->commit();
            $_SESSION['message'] = "Your Data is Deleted";
            header('Location: gebruiker.php');
        } else {
            $verbinding->rollBack();
            $_SESSION['message'] = "Your Data is NOT DELETED";
            header('Location: gebruiker.php');
        }
    } catch (PDOException $e) {
        $verbinding->rollBack();
        echo "Error: " . $e->getMessage();
    }
}