<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\UseCases\SaveTravelOrderUseCase;
use App\Domain\Entities\TravelOrder;
use App\Domain\Enums\TravelOrderStatus;
use App\Domain\Repositories\TravelOrderRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class SaveTravelOrderUseCaseTest extends TestCase
{
    private SaveTravelOrderUseCase $unit;
    private MockObject $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(TravelOrderRepositoryInterface::class);
        $this->unit = app(SaveTravelOrderUseCase::class, [
            'repository' => $this->repository,
        ]);
    }

    public function testSaveTravelOrder(): void
    {
        $order = new TravelOrder(
            requesterName: 'John Doe',
            destination: 'Paris',
            departureDate: new \DateTime('2023-10-01'),
            returnDate: new \DateTime('2023-10-10'),
            status: TravelOrderStatus::PENDING
        );

        $this->repository
            ->expects($this->once())
            ->method('create')
            ->with($this->equalTo($order))
            ->willReturn($order);
        $result = $this->unit->execute($order);

        $this->assertInstanceOf(TravelOrder::class, $result);
    }
}