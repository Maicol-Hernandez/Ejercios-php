<?php

class GenerarTablaJourney
{
    private $strGuionIdBD;
    public $errors;

    public function __construct(string $strGuionIdBD)
    {
        global $BaseDatos;
        global $mysqli;

        $this->strGuionIdBD = $strGuionIdBD;
        $this->BaseDatos = $BaseDatos;
        $this->mysqli = $mysqli;
        $this->errors = [];
    }


    private function createTableJourney(): void
    {
        # armo la sentencia sql para crear la tabla

        $sql = "CREATE TABLE IF NOT EXISTS `{$this->BaseDatos}`.`{$this->strGuionIdBD}_J` (
            `{$this->strGuionIdBD}_J_ConsInte_b` INT(255) NOT NULL,
            `{$this->strGuionIdBD}_J_ConsInte__GUION__Pob_b` INT(255) DEFAULT NULL,
            `{$this->strGuionIdBD}_J_Fecha_Hora_b` DATETIME DEFAULT NULL,
            `{$this->strGuionIdBD}_J_Duracion___b` TIME DEFAULT NULL,
            `{$this->strGuionIdBD}_J_Agente` INT(255) DEFAULT NULL,
            `{$this->strGuionIdBD}_J_Sentido___b` VARCHAR(10) COLLATE UTF8_BIN DEFAULT NULL,
            `{$this->strGuionIdBD}_J_Canal_____b` VARCHAR(20) COLLATE UTF8_BIN DEFAULT NULL,
            `{$this->strGuionIdBD}_J_DatoContacto` VARCHAR(255) COLLATE UTF8_BIN DEFAULT NULL,
            `{$this->strGuionIdBD}_J_NombrePaso` VARCHAR(255) COLLATE UTF8_BIN DEFAULT NULL,
            `{$this->strGuionIdBD}_J_Tipificacion_b` VARCHAR(100) COLLATE UTF8_BIN DEFAULT NULL,
            `{$this->strGuionIdBD}_J_Clasificacion_b` SMALLINT(5) DEFAULT NULL,
            `{$this->strGuionIdBD}_J_TipoReintento_b` SMALLINT(5) DEFAULT NULL,
            `{$this->strGuionIdBD}_J_Comentario_b` LONGTEXT COLLATE UTF8_BIN,
            `{$this->strGuionIdBD}_J_LinkContenido_b` VARCHAR(500) COLLATE UTF8_BIN DEFAULT NULL,
            PRIMARY KEY (`{$this->strGuionIdBD}_J_ConsInte_b`),
            UNIQUE KEY `{$this->strGuionIdBD}_J_ConsInte_b_UNIQUE` (`{$this->strGuionIdBD}_J_ConsInte_b`),
            UNIQUE KEY `{$this->strGuionIdBD}_J_ConsInte__GUION__Pob_b_UNIQUE` (`{$this->strGuionIdBD}_J_ConsInte__GUION__Pob_b`),
            INDEX (`{$this->strGuionIdBD}_J_ConsInte_b`),
            INDEX (`{$this->strGuionIdBD}_J_ConsInte__GUION__Pob_b`)
        ) ENGINE=INNODB DEFAULT CHARSET=UTF8 COLLATE = UTF8_BIN";

        mysqli_query($this->mysqli, $sql);

        $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
        $this->mistakes(
            $sql,
            $estado,
            $this->mysqli->error
        );

        echo "<br> createTable->this->errors =>", json_encode($this->errors), "<br>";
    }

    protected function addPrimaryKey(string $strNombreColumna): void
    {
        # code...
        $sql = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD PRIMARY KEY ({$this->strGuionIdBD}_J_{$strNombreColumna})";

        $this->mysqli->query($sql);

        $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';

        $this->mistakes(
            $sql,
            $estado,
            $this->mysqli->error
        );
    }

    // agregamos el index
    protected function addIndex(string $strNombreColumna): void
    {
        # code...
        $sql = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD INDEX ({$this->strGuionIdBD}_J_{$strNombreColumna})";

        // echo "<br> addIndex->sql => $sql <br>";
        $this->mysqli->query($sql);

        $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';

        $this->mistakes(
            $sql,
            $estado,
            $this->mysqli->error
        );
    }

    // agregamos unique id a la columna
    protected function addUnique(string $strNombreColumna): void
    {
        # code...
        $sql = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD UNIQUE INDEX {$this->strGuionIdBD}_J_{$strNombreColumna}_UNIQUE ({$this->strGuionIdBD}_J_{$strNombreColumna} ASC)";

        // echo "<br> addUnique->sql => $sql <br>";

        $this->mysqli->query($sql);

        $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';

        $this->mistakes(
            $sql,
            $estado,
            $this->mysqli->error
        );
    }

    // validamos el campo _J_ConsInte_b
    protected  function consInte(): void
    {
        # code...
        if ($this->validateField("ConsInte_b")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_ConsInte_b INT(255) NOT NULL FIRST";

            $this->mysqli->query($sqlAlter);

            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );

            $this->addPrimaryKey('ConsInte_b');
            $this->addIndex('ConsInte_b');
            $this->addUnique('ConsInte_b');
        }
    }


    // validamos el campo _J_ConsInte__GUION__Pob_b
    protected  function consInteGUION_Pob(): void
    {
        # code...
        if ($this->validateField("ConsInte__GUION__Pob_b")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_ConsInte__GUION__Pob_b INT(255) NOT NULL";
            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';

            $this->mysqli->query($sqlAlter);
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );

            $this->addIndex('ConsInte__GUION__Pob_b');
            $this->addUnique('ConsInte__GUION__Pob_b');
        }
    }

    // validamos el campo _J_Fecha_Hora_b
    protected  function fechaHora_b(): void
    {
        # code...
        if ($this->validateField("Fecha_Hora_b")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_Fecha_Hora_b DATETIME DEFAULT NULL";

            $this->mysqli->query($sqlAlter);

            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );
        }
    }

    // validamos el campo _J_Duracion___b
    protected  function duracion___b(): void
    {
        # code...
        if ($this->validateField("Duracion___b")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_Duracion___b TIME DEFAULT NULL";

            $this->mysqli->query($sqlAlter);

            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );
        }
    }

    // validamos el campo _J_Agente
    protected  function agente(): void
    {
        # code...
        if ($this->validateField("Agente")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_Agente INT(255) DEFAULT NULL";

            $this->mysqli->query($sqlAlter);

            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );
        }
    }

    // validamos el campo _J_Sentido___b
    protected  function sentido___b(): void
    {
        # code...
        if ($this->validateField("Sentido___b")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_Sentido___b VARCHAR(10) COLLATE UTF8_BIN DEFAULT NULL";

            $this->mysqli->query($sqlAlter);

            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );
        }
    }

    // validamos el campo _J_Canal_____b
    protected  function canal_____b(): void
    {
        # code...
        if ($this->validateField("Canal_____b")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_Canal_____b VARCHAR(20) COLLATE UTF8_BIN DEFAULT NULL";

            $this->mysqli->query($sqlAlter);

            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );
        }
    }

    // validamos el campo _J_DatoContacto
    protected  function datoContacto(): void
    {
        # code...
        if ($this->validateField("DatoContacto")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_DatoContacto VARCHAR(255) COLLATE UTF8_BIN DEFAULT NULL";

            $this->mysqli->query($sqlAlter);

            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );
        }
    }

    // validamos el campo _J_NombrePaso
    protected  function nombrePaso(): void
    {
        # code...
        if ($this->validateField("NombrePaso")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_NombrePaso VARCHAR(255) COLLATE UTF8_BIN DEFAULT NULL";

            $this->mysqli->query($sqlAlter);

            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );
        }
    }

    // validamos el campo _J_Tipificacion_b
    protected  function tipificacion_b(): void
    {
        # code...
        if ($this->validateField("Tipificacion_b")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_Tipificacion_b VARCHAR(100) COLLATE UTF8_BIN DEFAULT NULL";

            $this->mysqli->query($sqlAlter);

            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );
        }
    }

    // validamos el campo _J_Clasificacion_b
    protected  function clasificacion_b(): void
    {
        # code...
        if ($this->validateField("Clasificacion_b")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_Clasificacion_b SMALLINT(5) DEFAULT NULL";

            $this->mysqli->query($sqlAlter);

            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );
        }
    }

    // validamos el campo _J_TipoReintento_b
    protected  function tipoReintento_b(): void
    {
        # code...
        if ($this->validateField("TipoReintento_b")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_TipoReintento_b SMALLINT(5) DEFAULT NULL";

            $this->mysqli->query($sqlAlter);

            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );
        }
    }

    // validamos el campo _J_Comentario_b
    protected  function comentario_b(): void
    {
        # code...
        if ($this->validateField("Comentario_b")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_Comentario_b LONGTEXT COLLATE UTF8_BIN";

            $this->mysqli->query($sqlAlter);

            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );
        }
    }


    // validamos el campo _J_LinkContenido_b
    protected  function linkContenido_b(): void
    {
        # code...
        if ($this->validateField("LinkContenido_b")) {
            $sqlAlter = "ALTER TABLE {$this->BaseDatos}.{$this->strGuionIdBD}_J ADD {$this->strGuionIdBD}_J_LinkContenido_b VARCHAR(500) COLLATE UTF8_BIN DEFAULT NULL";

            $this->mysqli->query($sqlAlter);

            $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
            $this->mistakes(
                $sqlAlter,
                $estado,
                $this->mysqli->error
            );
        }
    }

    protected function validateField(string $field): bool
    {
        # code...
        $valido = true; // no existe el campo en la tabla G###_J
        $sql = "SHOW COLUMNS FROM {$this->BaseDatos}.{$this->strGuionIdBD}_J WHERE Field = '{$this->strGuionIdBD}_J_{$field}'";
        $result = $this->mysqli->query($sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $valido = false; // existe un campo, en la tabla G###_J

        }

        $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';

        $this->mistakes(
            $sql,
            $estado,
            $this->mysqli->error
        );

        return $valido;
    }

    // armo el array con lo errores
    public function mistakes(string $consulta, string $estado, string $mensaje): void
    {
        # code...

        $mensaje = $estado == 'ok' ?
            array("strSQL" =>  $consulta, "strMensaje" => "La consulta se ejecutó correctamente {$mensaje}", "strEstado" => $estado)
            :
            array("strSQL" =>  $consulta, "strMensaje" => "La consulta falló {$mensaje}", "strEstado" => "$estado");

        // array("strSQL" =>  $consulta, "strEstado" => $estado, "strMensaje" => $mensaje)

        array_push($this->errors, $mensaje);
    }


    // validamos la tabla si ya existe
    public function validateTable(): bool
    {
        # code...
        $valido = false; // no existe la tabla G###_J 

        $consulta = "SHOW TABLES FROM {$this->BaseDatos} WHERE Tables_in_DYALOGOCRM_WEB = '{$this->strGuionIdBD}_J'";

        $sql = mysqli_query($this->mysqli, $consulta);
        if ($sql && mysqli_num_rows($sql) > 0) {
            # code...
            $valido = true; // existe la tabla G###_J
        }

        $estado = $this->mysqli->errno === 0 ? 'ok' : 'fallo';
        $this->mistakes(
            $consulta,
            $estado,
            $this->mysqli->error
        );

        return $valido;
    }

    public function createFields(): void
    {
        # code...
        $this->consInte(); // validamos el campo _J_ConsInte_b
        $this->consInteGUION_Pob(); // validamos el campo _J_ConsInte__GUION__Pob_b
        $this->fechaHora_b(); // validamos el campo _J_Fecha_Hora_b
        $this->duracion___b(); // validamos el campo _J_Duracion___b
        $this->agente(); // validamos el campo _J_Agente
        $this->sentido___b(); // validamos el campo _J_Sentido___b
        $this->canal_____b(); // validamos el campo _J_Canal_____b
        $this->datoContacto(); // validamos el campo _J_DatoContacto
        $this->nombrePaso(); // validamos el campo _J_NombrePaso
        $this->tipificacion_b(); // validamos el campo _J_Tipificacion_b
        $this->clasificacion_b(); // validamos el campo _J_Clasificacion_b
        $this->tipoReintento_b(); // validamos el campo _J_TipoReintento_b
        $this->comentario_b(); // validamos el campo _J_Comentario_b
        $this->linkContenido_b(); // validamos el campo _J_LinkContenido_b

        echo "<br> createFields->this->errors =>", json_encode($this->errors), "<br>";
    }

    public function createTable(): void
    {
        $this->createTableJourney();
    }
}
