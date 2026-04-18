<?php
declare(strict_types=1);

final class NewsController {
    public function __construct(
        private NewsWebMapper $mapper,
        private CreateNewsUseCase $createNewsUseCase,
        private GetAllNewsUseCase $getAllNewsUseCase
    ) {}

    public function index(): array {
        $newsModels = $this->getAllNewsUseCase->execute();
        // Usaríamos un método del mapper similar al de usuarios
        return $this->mapper->fromModelsToResponses($newsModels);
    }

    public function store(array $requestData): void {
        $command = $this->mapper->fromCreateRequestToCommand($requestData);
        $this->createNewsUseCase->execute($command);
    }
}