<?php
declare(strict_types=1);

final class NewsModel {
    public function __construct(
        private string $id,
        private string $categoria,
        private string $fecha,
        private string $pais,
        private string $departamento,
        private string $ciudad,
        private string $periodista,
        private string $programaEmite,
        private string $fechaEmision,
        private string $descripcion,
        private string $nivelPublico
    ) {}

    // Getters
    public function id(): string { return $this->id; }
    public function categoria(): string { return $this->categoria; }
    public function fecha(): string { return $this->fecha; }
    public function pais(): string { return $this->pais; }
    public function departamento(): string { return $this->departamento; }
    public function ciudad(): string { return $this->ciudad; }
    public function periodista(): string { return $this->periodista; }
    public function programaEmite(): string { return $this->programaEmite; }
    public function fechaEmision(): string { return $this->fechaEmision; }
    public function descripcion(): string { return $this->descripcion; }
    public function nivelPublico(): string { return $this->nivelPublico; }
}