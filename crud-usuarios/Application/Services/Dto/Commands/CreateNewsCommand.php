<?php
declare(strict_types=1);

final class CreateNewsCommand {
    public function __construct(
        public string $id,
        public string $categoria,
        public string $fecha,
        public string $pais,
        public string $departamento,
        public string $ciudad,
        public string $periodista,
        public string $programaEmite,
        public string $fechaEmision,
        public string $descripcion,
        public string $nivelPublico
    ) {}
}