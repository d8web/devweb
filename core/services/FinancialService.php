<?php

namespace core\services;

use core\helpers\Database;

class FinancialService {

    public static function addFinancialInDatabase($idClient, $namePayment, $paymentValue, $expired, $status) {

        $params = [
            ":clientId" => $idClient,
            ":name" => $namePayment,
            ":value" => $paymentValue,
            ":expired" => $expired,
            ":status" => $status
        ];

        $db = new Database();
        $db->insert("INSERT INTO financial VALUES (0, :clientId, :name, :value, :expired, :status)", $params);

    }

    public static function getListPaymentFromClient(int $id, int $status) {

        $params = [ ":clientId" => $id, ":status" => $status ];

        $db = new Database();
        $result = $db->select("
            SELECT clients.name as clientName, financial.*
            FROM clients, financial
            WHERE financial.clientId = :clientId
            AND financial.clientId = clients.id
            AND financial.status = :status
            ORDER BY financial.expired ASC",
        $params);

        return $result;

    }

    public static function getListPaymentsFromStatus($status) {

        $params = [ ":status" => $status ];

        $db = new Database();
        $result = $db->select("
            SELECT clients.name as clientName, clients.id, clients.email, financial.*
            FROM clients, financial
            WHERE financial.clientId = clients.id
            AND financial.status = :status
            ORDER BY financial.expired ASC
            LIMIT 10",
        $params);

        return $result;

    }

    public static function verifyIdAndClientIdInDatabase($idFinance, $idClient) {

        $params = [
            ":id" => $idFinance,
            ":clientId" => $idClient
        ];

        $db = new Database();
        $result = $db->select("SELECT * FROM financial WHERE id = :id AND clientId = :clientId", $params)[0];

        if($result) {
            return $result;
        }

        return false;

    }

    public static function verifyIdInDatabase($idFinance) {

        $params = [
            ":id" => $idFinance
        ];

        $db = new Database();
        $result = $db->select("SELECT * FROM financial WHERE id = :id", $params)[0];

        if($result) {
            return $result;
        }

        return false;

    }

    public static function alterStatusPaidInDatabase($idFinance, $idClient) {

        $params = [
            ":id" => $idFinance,
            ":clientId" => $idClient
        ];

        $db = new Database();
        $db->update("UPDATE financial SET status = 1 WHERE id = :id AND clientId = :clientId", $params);

    }

    public static function alterAnotherStatusPaidInDatabase($idFinance) {

        $params = [
            ":id" => $idFinance
        ];

        $db = new Database();
        $db->update("UPDATE financial SET status = 1 WHERE id = :id", $params);

    }

    public static function getPortionsFromId($id) {

        $params = [
            ":id" => $id
        ];

        $db = new Database();
        return $db->select("SELECT * FROM financial WHERE id = :id", $params)[0];

    }

}