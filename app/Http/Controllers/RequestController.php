<?php

namespace App\Http\Controllers;

use App\Data\RequestData;
use App\Interfaces\MailServiceInterface;
use App\Services\RequestService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="API Документация для RequestController",
 *     version="1.0.0",
 *     description="Контроллер для управления заявками (requests): создание, получение списка, обновление."
 * )
 *
 * @OA\Tag(
 *     name="Request",
 *     description="Операции с заявками пользователей"
 * )
 *
 * @OA\Schema(
 *     schema="Request",
 *     type="object",
 *     title="Request",
 *     description="Модель заявки",
 *     required={"name", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Иван Иванов"),
 *     @OA\Property(property="email", type="string", format="email", example="ivan@example.com"),
 *     @OA\Property(property="$message", type="string", example="Тестовое сообщение"),
 *     @OA\Property(property="status", type="string", example="Active", description="Статус заявки: Active, Resolved"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T12:00:00Z")
 * )
 */
class RequestController extends Controller
{
    /**
     * @param RequestService $requestService
     * @param MailServiceInterface $mailService
     */
    public function __construct(
        protected RequestService $requestService,
        protected MailServiceInterface $mailService
    ) {
    }

    /**
     * Получение списка заявок с фильтрацией.
     *
     * Возвращает список заявок на основе переданных параметров фильтрации.
     *
     * @OA\Get(
     *     path="/api/requests",
     *     tags={"Request"},
     *     summary="Получить список заявок",
     *     description="Позволяет получить список заявок с возможностью фильтрации через параметры запроса.",
     *     operationId="index",
     *
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         description="Фильтр по статусу заявки",
     *         @OA\Schema(type="string", example="Active")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Список заявок успешно получен",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Request")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Неверные параметры запроса"
     *     )
     * )
     *
     * @param RequestData $data Объект данных запроса (DTO).
     * @return JsonResponse JSON-ответ со списком заявок.
     */
    public function index(RequestData $data): JsonResponse
    {
        $requests = $this->requestService->getData($data);
        return response()->json(RequestData::collect($requests));
    }

    /**
     * Создание новой заявки.
     *
     * Принимает данные заявки и сохраняет её в системе.
     *
     * @OA\Post(
     *     path="/api/requests",
     *     tags={"Request"},
     *     summary="Создать новую заявку",
     *     description="Создаёт новую заявку на основе переданных данных.",
     *     operationId="save",
     *
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=true,
     *         description="Имя заявителя",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *         description="Email заявителя",
     *         @OA\Schema(type="string", format="email")
     *     ),
     *     @OA\Parameter(
     *         name="message",
     *         in="query",
     *         required=true,
     *         description="Сообщение",
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Заявка успешно создана",
     *         @OA\JsonContent(ref="#/components/schemas/Request")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации данных"
     *     )
     * )
     *
     * @param RequestData $data Объект данных запроса (DTO).
     * @return JsonResponse JSON-ответ с созданной заявкой и статусом 201.
     */
    public function save(RequestData $data): JsonResponse
    {
        $newRequest = $this->requestService->create($data);
        return response()->json($newRequest, 201);
    }

    /**
     * Обновление существующей заявки.
     *
     * Обновляет данные заявки по ID и отправляет уведомление на email.
     *
     * @OA\Put(
     *     path="/api/requests",
     *     tags={"Request"},
     *     summary="Обновить заявку",
     *     description="Обновляет заявку и отправляет email-уведомление о завершении.",
     *     operationId="update",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="ID заявки",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=false,
     *         description="Новое имя заявителя",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=false,
     *         description="Новый email",
     *         @OA\Schema(type="string", format="email")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=true,
     *         description="Новый статус заявки",
     *         @OA\Schema(type="string", example="Resolved")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Заявка успешно обновлена",
     *         @OA\JsonContent(ref="#/components/schemas/Request")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Заявка не найдена"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
     *
     * @param RequestData $data Объект данных запроса (DTO).
     * @return JsonResponse JSON-ответ с обновлённой заявкой.
     */
    public function update(RequestData $data): JsonResponse
    {
        $updatedRequest = $this->requestService->update($data);
        $this->mailService->sendRequestResolved($updatedRequest);
        return response()->json($updatedRequest);
    }
}
