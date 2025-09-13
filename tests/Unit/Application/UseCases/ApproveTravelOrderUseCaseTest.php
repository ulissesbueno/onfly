<?php

namespace Tests\Unit\Application\UseCases;
use Tests\TestCase;
use App\Application\UseCases\ApproveTravelOrderUseCase;
use App\Domain\Entities\TravelOrder;
use App\Domain\Entities\User;
use App\Domain\Enums\TravelOrderStatus;
use App\Domain\Repositories\TravelOrderRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Illuminate\Support\Facades\Event;
use App\Events\TravelOrderStatusChange;

class ApproveTravelOrderUseCaseTest extends TestCase
{
    private ApproveTravelOrderUseCase $unit;
    private MockObject $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(TravelOrderRepositoryInterface::class);
        $this->unit = app(ApproveTravelOrderUseCase::class, [
            'repository' => $this->repository,
        ]);
    }

    public function testApproveTravelOrderSuccess(): void
    {
        Event::fake();

        $returnRepository = new TravelOrder(
            id: 1,
            requesterName: 'John Doe',
            destination: 'Paris',
            departureDate: new \DateTime('2023-10-01'),
            returnDate: new \DateTime('2023-10-10'),
            status: TravelOrderStatus::PENDING,
            user: new User(
                id: 2,
                name: 'Any User',
                email: 'any@example.com'
            )
        );

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($this->equalTo(1))
            ->willReturn($returnRepository);

        $orderChanged = clone $returnRepository;
        $orderChanged->setStatus(TravelOrderStatus::APPROVED);

        $this->repository
            ->expects($this->once())
            ->method('update')
            ->with($this->equalTo($orderChanged))
            ->willReturn($orderChanged);

        $result = $this->unit->execute(1, 1);

        $this->assertInstanceOf(TravelOrder::class, $result);
        $this->assertEquals(TravelOrderStatus::APPROVED, $result->getStatus());

        Event::assertDispatched(TravelOrderStatusChange::class, function ($event) use ($orderChanged) {
            return $event->travelOrder->getId() === $orderChanged->getId()
                && $event->travelOrder->getStatus() === $orderChanged->getStatus();
        });
    }

    public function testApproveTravelOrderNotFound(): void
    {
        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($this->equalTo(999))
            ->willReturn(null);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Pedido não encontrado.");

        $this->unit->execute(999, 1);
    }
    
    public function testApproveTravelOrderUserCannotChangeOwnRequest(): void
    {
        $returnRepository = new TravelOrder(
            id: 1,
            requesterName: 'John Doe',
            destination: 'Paris',
            departureDate: new \DateTime('2023-10-01'),
            returnDate: new \DateTime('2023-10-10'),
            status: TravelOrderStatus::PENDING,
            user: new User(
                id: 1,
                name: 'John Doe',
                email: 'john@example.com'
            )
        );

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($this->equalTo(1))
            ->willReturn($returnRepository);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Um usuário não pode aprovar ou cancelar seu próprio pedido.");

        $this->unit->execute(1, 1);
    }
}