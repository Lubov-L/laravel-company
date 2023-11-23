### Настойка и развертывание проекта

#### Требования к окружению

- Docker
- Утилита make для работы с Makefile

#### Настройка проекта 
- Выполнить клонирование проекта командой  
``git clone git@github.com:Lubov-L/laravel-company.git``
- Перейти в папку проекта
- Выполнить команду ``make install`` 
- Требуется в .env внести данные для коннекта к базе данных
```
  DB_CONNECTION=mysql
  DB_HOST=mysql-laravel-crud
  DB_PORT=3306
  DB_DATABASE=laravel-crud
  DB_USERNAME=laravel
  DB_PASSWORD=laravel
```
- Выполнить команду ``make migrate``  

#### Настройка проекта завершена

---

### API Документация
[Ссылка на документацию](https://documenter.getpostman.com/view/27410151/2s9YeBdtDq)

