<?php

// Declaramos el uso estricto de tipos
declare( strict_types=1 );

namespace DB;

require_once __DIR__ . '/../../autoload.php';

use \Base\Empleado as empleado;
use \Base\Familiar as familiar;
use \Base\Individuo as individuo;

class operacionesBBDD {

    private string $nombreBBDD;
    private string $usuario;
    private string $pwd;
    private string $servidor;
    private object $PDO;

    /**
     * Constructor
     */
    function __construct() {

        try {
            $dbConfigData = $this->leer_configuración(__DIR__ . '/../../Config/configuracion.xml', __DIR__ . '/../../Config/configuracion.xsd');
        } catch (\TypeError $e) {
            echo "A type error occured: " . $e->getMessage();
            die();
        } catch (\Exception $e) {
            echo "A Exception error occured: " . $e->getMessage();
            die();
        }

        $this->nombreBBDD = $dbConfigData['dbname'];
        $this->usuario = $dbConfigData['dbuser'];
        $this->servidor = $dbConfigData['dbserver'];
        $this->pwd = $dbConfigData['dbpwd'];
        $this->PDO = $this->connect();
    }

    protected function connect(): \PDO {
        try {

            $pdo = new \PDO("mysql:host={$this->servidor};dbname={$this->nombreBBDD};charset=utf8", $this->usuario, $this->pwd);

            return $pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function __destruct() {
        unset($this->PDO);
    }

    /**
     * Función que lee el archivo de configuración de la base de datos
     * 
     * @param string $xml_file cadena de texto con la ruta del archivo xml
     * @param string $xsd cadena de texto con la ruta del archivo xsd
     * @return array devuelve un array asociativo con los datos de la conexión
     * @throws \PDOException
     */
    function leer_configuración(string $xml_file, string $xsd): array {

        $datosConfig = array();

        $config = new \DOMDocument();

        $config->load($xml_file); // Cargamos el xml

        if (!$config->schemaValidate($xsd)) { // Comprobamos si el xml No es valido
            throw new \PDOException("El fichero de configuración no es correcto");
        }

        // Leemos el fichero de configuración xml
        $xml = simplexml_load_file($xml_file);

        // Asignamos los datos de la conexión a un array asociativo
        $datosConfig['dbserver'] = "" . $xml->xpath('//servidor')[0];
        $datosConfig['dbname'] = "" . $xml->xpath('//nombre')[0];
        $datosConfig['dbuser'] = "" . $xml->xpath('//usuario')[0];
        $datosConfig['dbpwd'] = "" . $xml->xpath('//clave')[0];

        return $datosConfig;
    }

    /**
     * Función de la interfaz serialize
     * 
     * @return string devuelve una cadena de texto con el objecto serializado
     */
    public function __serialize() {
        return [
            'nombreBBDD' => $this->nombreBBDD,
            'usuario' => $this->usuario,
            'pwd' => $this->pwd,
            'servidor' => $this->servidor
        ];
    }

    /**
     * Función que deseliza un objecto recuperando sus datos
     * 
     * @param string $data
     * @return void
     */
    public function __unserialize($data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        try {
            // Recuperamos el puntero de la conexión
            $this->PDO = $this->connect();
        } catch (\PDOException $e) {
            echo "<br>A PDO error occured: " . $e->getMessage();
        } catch (\Exception $e) {
            echo '<br>A Exception error occured: ' . $e->getMessage();
        }
    }

    /**
     * Función para buscar los familiares de un empleado y devuelve sus IDS
     * 
     * @param type $id_empleado
     * @return array devuelve un array vacio si ese familiar no tiene
     * familiares o en caso contrario todos los ids de sus familiares
     */
    function obtenerIdsFamiliares($id_empleado) {
        $familiares = array();

        $sql = "select id_familia from empleados 
	inner join familiares
	on empleados.ID_EMPLEADO = familiares.EMPLEADO
		where empleados.ID_EMPLEADO = ?;";

        $db = $this->PDO;

        if (($stmt = $db->prepare($sql))) { // Sentencia preparada
            $stmt->bindValue(1, $id_empleado, \PDO::PARAM_INT);

            $stmt->execute();

            // Bucle para obtener todos los familiares
            while ($row = $stmt->fetch(\PDO::FETCH_BOTH)) {
                array_push($familiares, $row['id_familia']);
            }
        } else {
            echo "Se a producido un error: " . print_r($db->errorInfo());
        }

        /*
         * Realizamos el unset de $stmt para resetear el puntero de la consulta PDO,
         * ya que conviene siempre liberar los recursos no utilizados
         */
        unset($stmt);

        return $familiares;
    }

    /**
     * Funcion que borra los familiares de un empleado y nos indica cuantos borra
     * 
     * @param number $id_empleado número del empleado
     * @return number devuelve el número de familiares borrados
     * @throws \Exception
     */
    function borrarFamiliares($id_empleado) {

        $db = $this->PDO;

        $sql = "DELETE
                FROM familiares
                    WHERE empleado = ?;";

        $borrados = 0;

        try {
            // Iniciamos la transacción,
            $db->beginTransaction();

            $stmt = $db->prepare($sql); // Preparamos la consulta

            $stmt->bindValue(1, $id_empleado, \PDO::PARAM_INT);

            if ($stmt->execute()) { // Ejecutamos el borrado
                $borrados++;
            }

            //Si fue todo correcto hacemos commit
            $db->commit();
        } catch (\Exception $e) {
            $borrados = 0;
            $db->rollback();
            throw $e;
        }

        /*
         * Realizamos el unset de $stmt para resetear el puntero de la consulta PDO,
         * ya que conviene siempre liberar los recursos no utilizados
         */
        unset($stmt);

        return $borrados;
    }

    /**
     * Fuunción que busca todos los datos de un usuario
     * 
     * @param number $id número del ID del empleado
     * @return Object devuelve un objecto empleado o una string vacia si no existe 
     */
    function buscar_datos_empleado($id) {
        $empleado = "";

        $sql = "select * 
                 from empleados
                   where empleados.ID_EMPLEADO = ?;";

        $db = $this->PDO;

        if (($stmt = $db->prepare($sql))) { // Sentencia preparada
            $stmt->bindValue(1, $id, \PDO::PARAM_INT);

            $stmt->execute();
            // Obtenemos los datos del empleado
            if (($row = $stmt->fetch(\PDO::FETCH_BOTH))) {

                $familiares = $this->obtenerDatosFamiliares($id);

                // Si tiene supervisor lo buscamos
                $supervisor = isset($row['SUPERVISOR']) ? $this->obtenerSupervisor($row['SUPERVISOR']) : 'No tiene';

                $empleado = new empleado($row['ID_EMPLEADO'], $row['NIF'], $row['NOMBRE'], $row['SEXO'],
                        $row['FECHA_NAC'], $row['NSS'], $row['DIRECCION'], $row['SALARIO'], $row['DEPARTAMENTO'], $supervisor, $familiares);
            }
        } else {
            echo "Se a producido un error: " . print_r($db->errorInfo());
        }

        unset($stmt);

        return $empleado;
    }

    /**
     * Función para obtener el supervisor
     * 
     * @return mixed devuelve una cadena vacia si el usuario no tiene supervisor,
     * en caso contrario devuelve un objecto Individuo con los datos del supervisor
     */
    function obtenerSupervisor($id) {
        $supervisor = "";

        $sql = "select * 
                 from empleados
                   where empleados.ID_EMPLEADO = ?;";

        $db = $this->PDO;

        if (($stmt = $db->prepare($sql))) { // Sentencia preparada
            $stmt->bindValue(1, $id, \PDO::PARAM_INT);

            $stmt->execute();
            // Obtenemos los datos del empleado
            if (($row = $stmt->fetch(\PDO::FETCH_BOTH))) {
                $familiares = $this->obtenerDatosFamiliares($id);
                $supervisor = new individuo($row['ID_EMPLEADO'], $row['NIF'], $row['NOMBRE'], $row['SEXO'], $row['FECHA_NAC']);
            }
        } else {
            echo "Se a producido un error: " . print_r($db->errorInfo());
        }

        unset($stmt);

        return $supervisor;
    }

    /**
     * Función que obtiene los datos de los familiares
     * 
     * @param Number $id_empleado número del ID del empleado a buscar
     * @return array devuelve los datos de los familiarares del empleado
     */
    function obtenerDatosFamiliares($id_empleado) {
        $familiares = array();

        $sql = "select familiares.ID_FAMILIA, familiares.NIF, familiares.NOMBRE, familiares.SEXO, familiares.FECHA_NAC, familiares.PARENTESCO, familiares.EMPLEADO
	from empleados 
		inner join familiares
			on empleados.ID_EMPLEADO = familiares.EMPLEADO
				where empleados.ID_EMPLEADO = ?;";

        $db = $this->PDO;

        if (($stmt = $db->prepare($sql))) { // Sentencia preparada
            $stmt->bindValue(1, $id_empleado, \PDO::PARAM_INT);

            $stmt->execute();

            // Bucle para obtener todos los familiares
            while ($row = $stmt->fetch(\PDO::FETCH_BOTH)) {
                $familiar = new familiar($row['ID_FAMILIA'], $row['NIF'], $row['NOMBRE'], $row['SEXO'], $row['FECHA_NAC'], $row['PARENTESCO'], $row['EMPLEADO']);
                array_push($familiares, $familiar);
            }
        } else {
            echo "Se a producido un error: " . print_r($db->errorInfo());
        }

        unset($stmt);

        return $familiares;
    }

    /**
     * Función que obtiene el nombre y id de todos los empleados
     * 
     * @return string devuelve una string con las opciones para el select
     */
    function obtenerIDs_Empleados() {
        $options = "";

        $sql = "select empleados.ID_EMPLEADO, empleados.NOMBRE
                 from empleados";

        $db = $this->PDO;

        if (($stmt = $db->query($sql))) {

            // Bucle para obtener todos los empleados
            while ($row = $stmt->fetch(\PDO::FETCH_BOTH)) {

                $options .= '<option value ="' . $row['ID_EMPLEADO'] . '">' . $row['NOMBRE'] . '</option>';
            }
        } else {
            echo "Se a producido un error: " . print_r($db->errorInfo());
        }

        unset($stmt);
        return $options;
    }

}
