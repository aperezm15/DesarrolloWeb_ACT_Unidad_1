<?php
declare(strict_types=1);

final class NewsWebMapper {
    public function fromCreateRequestToCommand(array $post): CreateNewsCommand {
        return new CreateNewsCommand(
            bin2hex(random_bytes(16)), // Generamos ID
            $post['categoria'],
            $post['fecha'],
            $post['pais'],
            $post['departamento'],
            $post['ciudad'],
            $post['periodista'],
            $post['programaEmite'],
            $post['fechaEmision'],
            $post['descripcion'],
            $post['nivelPublico']
        );
    }
}