# klu-vanila-course
*Этот проект является частю прохождения стажировки*

Реализован следующий функционал:
1. Авторизация и аутентификация пользователя и его действий (в момент отоборажения и наступления действия)
2. CRUD пользователей и курсов
3. Изменение и добавления материала в курсе (взаимодействие с JSON)
4. Взаимодействие с базой данной создание таблиц, навешивание ключей реализация Soft Delete (колонка deleted_at)
5. Создание класса Router для корректных URL'ов
6. Для постраничного вывода контента создан класс Paginator
7. Преобразование проекта в паттерн MVC (раздаление зон ответственности)
8. Настройка сервера nginx

Страница аутентификации определяет права доступа.

![image](https://user-images.githubusercontent.com/81085234/232453529-f12a8f0d-ed39-42ac-8c2b-9b67fa72bb78.png)
![image](https://user-images.githubusercontent.com/81085234/232453635-1b4b0f95-7a7d-46ed-af28-e2630e67fda6.png)
![image](https://user-images.githubusercontent.com/81085234/232453658-e67c20c9-d94e-4b49-845f-76b6945b3131.png)

У каждого пользователя есть профиль и только сам пользователь может менять аватарку

![image](https://user-images.githubusercontent.com/81085234/232453733-d46d3fb5-34ac-47ba-974d-28895fbeed53.png)

Пользователь может только смотреть на других пользователей и курсы

![image](https://user-images.githubusercontent.com/81085234/232453983-edb24443-91b7-49f3-9b70-6709c02d88e4.png)
![image](https://user-images.githubusercontent.com/81085234/232454002-5fa487f5-7634-41ad-9cc4-a63d697a18c3.png)
![image](https://user-images.githubusercontent.com/81085234/232454114-17298ca0-9eba-451b-a4d9-3c682cf95ea5.png)

Учитель может так же создавать и редактировать курсы

![image](https://user-images.githubusercontent.com/81085234/232454244-0340b05b-6eae-4fc4-8a6d-a29180b9cbbc.png)
![image](https://user-images.githubusercontent.com/81085234/232454273-9355e286-4f40-4328-a994-331d4a9c2ff0.png)
![image](https://user-images.githubusercontent.com/81085234/232454286-22883d34-d760-4722-86ed-ea75cb00cc92.png)
![image](https://user-images.githubusercontent.com/81085234/232454300-f2fdc1a5-9380-4ac8-9eca-3804abfefd4b.png)
![image](https://user-images.githubusercontent.com/81085234/232454321-bf2effc9-2d6f-4e28-b4ff-a62d97c3cfb5.png)

Так же учитель выступает в роли админа и может изменять права и удалять пользователей(себя удалить не может)
![image](https://user-images.githubusercontent.com/81085234/232454574-d46141fb-8cfa-487d-ab6c-4139d49f50ee.png)
![image](https://user-images.githubusercontent.com/81085234/232454592-6dd10f6b-b5b4-44a8-bbef-60bc383ee5c0.png)
![image](https://user-images.githubusercontent.com/81085234/232454614-7a5a32ea-f6af-45fc-8788-713745a966cf.png)





