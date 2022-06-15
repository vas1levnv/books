drop table books;
drop table genres;
drop table authors;

create table authors
(
    id     int primary key auto_increment,
    author varchar(50)
);

insert authors (author)
values ('Воронин Андрей'),
       ('Роулинг Джоан Кэтлин'),
       ('Глушко Мария Васильевна'),
       ('Дюма Александр'),
       ('Васильев Борис Львович');

create table genres
(
    id    int primary key auto_increment,
    genre varchar(50)
);

insert genres (genre)
values ('Медицина и здоровье'),
       ('Зарубежное фэнтези'),
       ('Книги о войне'),
       ('Исторические приключения'),
       ('Современная проза');

create table books
(
    id          int primary key auto_increment,
    name        varchar(50),
    description varchar(250),
    images      varchar(100)
);

insert books (name, description, images)
values ('Диетологи, я вам не верю! Книга-разоблачение',
        'Прочитай и похудей. И узнай, что реклама еды по вечерам на ТВ.',
        'https://www.litmir.me/data/Book/0/684000/684143/BC4_1593543071.jpg'),
       ('Гарри Поттер и узник Азкабана',
        'Двенадцать долгих лет в Азкабане - мрачной тюрьме волшебного мира - содержался всем известный узник по имени Сириус Блэк.',
        'https://www.litmir.me/data/Book/0/37000/37514/BC4_1597200430.jpg'),
       ('Гарри Поттер и Кубок огня',
        'Гарри Поттеру предстоит четвёртый год обучения в Школе чародейства и волшебства «Хогвартс». Новые заклинания, новые зелья, новые учителя, новые предметы… ',
        'https://www.litmir.me/data/Book/0/164000/164713/BC4_1595686990.jpg'),
       ('В списках не значился',
        'На крайнем западе нашей страны стоит Брестская крепость. Совсем недалеко от Москвы: меньше суток идет поезд.',
        'https://www.litmir.me/data/Book/0/29000/29094/BC4_1597524492.jpg'),
    ('Три мушкетера (ил. М.Лелуара)',
        'Юный гасконец д''Артаньян полон дерзких планов покорить Париж.',
        'https://www.litmir.me/data/Book/0/166000/166003/BC4_1595668090.jpg'),
    ('Мадонна с пайковым хлебом',
        'Автобиографический роман писательницы, чья юность выпала на тяжёлые годы Великой Отечественной войны. Книга написана замечательным русским языком, очень искренне и честно.',
        'https://www.litmir.me/data/Book/0/166000/166003/BC4_1595668090.jpg');

create table books_and_genres
(
    id int primary key auto_increment,
    booksId int,
    genresId int,
    foreign key (booksId) references books(id),
    foreign key (genresId) references genres(id)
);

insert books_and_genres (booksId, genresId)
values (1,1),
       (2,2),
       (3,2),
       (4,3),
       (5,4),
       (6,5);


create table books_and_authors
(
    id int primary key auto_increment,
    booksId int,
    authorsId int,
    foreign key (booksId) references books(id),
    foreign key (authorsId) references authors(id)
);
insert books_and_authors (booksId, authorsId)
values (1,1),
       (2,2),
       (3,2),
       (4,5),
       (5,4),
       (6,3);



select b.name, b.description, b.images, a.author, g.genre from books b
                                                                   join books_and_authors baa on b.id = baa.booksId
                                                                   join authors a on a.id = baa.authorsId
                                                                   join books_and_genres bag on b.id = bag.booksId
                                                                   join genres g on bag.genresId = g.id
where name like 'Гарри%';