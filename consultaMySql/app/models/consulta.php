<?php


class Conexion
{

    private $host;
    private $user;
    private $passWord;
    private $con;


    function __construct()
    {
        $this->host = "mysql:host=10.25.1.9";
        $this->user = "devssv";
        $this->passWord = "Super2022*";
    }


    public function Conexion()
    {

        try {
            $this->con = new PDO($this->host, $this->user, $this->passWord);

            $query = $this->con->prepare("SET @row_number = 0;");
            $query->execute();


            $query = $this->con->prepare("
            SELECT DISTINCT idconversacion,remitente,destinatario,horaapertura,tiempo tiempoultmensaje,tiempoconversacion,horacierre
            FROM
            (SELECT
            DISTINCT ocp.conversationID idconversacion,oco.messageCount,
            replace(fromJID,'@webserver','') remitente,ogo.groupName gruporigen,
            replace(oma.toJID,'@webserver','') destinatario,ogd.groupName grupodestino,
            TIMEDIFF(FROM_UNIXTIME(oco.lastActivity/1000,'%Y-%m-%d %H:%i:%s %f'),FROM_UNIXTIME(oco.startDate/1000,'%Y-%m-%d %H:%i:%s %f')) tiempo,
            CASE WHEN FROM_UNIXTIME(ocp.leftDate/1000,'%Y-%m-%d %H:%i:%s') IS NULL THEN
            TIMEDIFF(NOW(),FROM_UNIXTIME(oco.startDate/1000,'%Y-%m-%d %H:%i:%s %f'))
            ELSE TIMEDIFF(FROM_UNIXTIME(oco.lastActivity/1000,'%Y-%m-%d %H:%i:%s %f'),FROM_UNIXTIME(oco.startDate/1000,'%Y-%m-%d %H:%i:%s %f'))
            END tiempoconversacion,
            oma.messageID idmensaje,
            body mensaje,
            FROM_UNIXTIME(ocp.joinedDate/1000,'%Y-%m-%d %H:%i:%s') horaapertura,
            FROM_UNIXTIME(ocp.leftDate/1000,'%Y-%m-%d %H:%i:%s') horacierre,
            FROM_UNIXTIME(oma.sentDate/1000,'%Y-%m-%d %H:%i:%s %f') horamensaje,
            FROM_UNIXTIME(oco.startDate/1000,'%Y-%m-%d %H:%i:%s %f') horainicio,
            FROM_UNIXTIME(oco.lastActivity/1000,'%Y-%m-%d %H:%i:%s %f') horaultactividad,
            (@row_num:=CASE
            When @cust_no=ocp.conversationID
            then
            @row_num+1
            else 1
            end) AS row_num
            FROM openfire.ofConversation oco, openfire.ofMessageArchive oma,  openfire.ofConParticipant ocp, openfire.ofGroupUser ogo, openfire.ofGroupUser ogd
            WHERE oco.conversationID=oma.conversationID
            AND oma.conversationID=ocp.conversationID
            AND ((FROM_UNIXTIME(oco.startDate/1000,'%Y-%m-%d %H:%i:%s')>(NOW() - INTERVAL 600 MINUTE) AND FROM_UNIXTIME(ocp.leftDate/1000,'%Y-%m-%d %H:%i:%s') IS NULL)
            OR (FROM_UNIXTIME(oco.startDate/1000,'%Y-%m-%d %H:%i:%s')>(NOW() - INTERVAL 60 MINUTE) AND FROM_UNIXTIME(ocp.leftDate/1000,'%Y-%m-%d %H:%i:%s') IS NOT NULL))
            AND replace(fromJID,'@webserver','')=ogo.username
            AND replace(oma.toJID,'@webserver','')=ogd.username
            AND (ogd.groupName IN ('CALL CENTER') )
            ORDER BY oma.conversationID ASC, horamensaje DESC) q
            WHERE q.row_num=1");


            $query->execute();

            $data = $query->fetchAll(PDO::FETCH_OBJ);

            return $data;
        } catch (Exception $e) {
            echo "error al conectar a la base de datos " . $e->getMessage() . "en la linea " . $e->getLine();
        }
    }
}