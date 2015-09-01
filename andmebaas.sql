CREATE TABLE events 
  ( 
     id          SERIAL, 
     event_title TEXT NOT NULL, 
     event_host  TEXT NOT NULL, 
     event_date  DATE NOT NULL, 
     event_desc  CHAR(100) NOT NULL, 
     event_loc   CHAR(50) NOT NULL 
  ); 

INSERT INTO "events" 
            (event_title, 
             event_host, 
             event_date, 
             event_desc, 
             event_loc) 
VALUES      ('Test event', 
             'Test host', 
             '2015-05-07', 
             'Some test description lorem ipsum', 
             'Tallinn, Estonia'); 

INSERT INTO "events" 
            (event_title, 
             event_host, 
             event_date, 
             event_desc, 
             event_loc) 
VALUES      ('Birthday party', 
             'Mihkel Maasikas', 
             '2015-06-20', 
             'Minu sünnipäeva pidamine. Tulge kõik - saab süüa ja juua!!!', 
             'Tartu, Estonia'); 

CREATE TABLE invitees 
  ( 
     id               SERIAL, 
     invitee_event_id INT NOT NULL, 
     invitee_email    TEXT NOT NULL, 
     invitee_name     TEXT NOT NULL 
  ); 

INSERT INTO "invitees" 
            (invitee_event_id, 
             invitee_email, 
             invitee_name) 
VALUES      (2, 
             'mari@murakas.ee', 
             'Mari Murakas'); 

INSERT INTO "invitees" 
            (invitee_event_id, 
             invitee_email, 
             invitee_name) 
VALUES      (2, 
             'jaana@jänes.ee', 
             'Jaana Jänes'); 

CREATE TABLE gifts 
  ( 
     id              SERIAL, 
     gift_event_id   INT NOT NULL, 
     gift_name       TEXT NOT NULL, 
     gift_link       TEXT, 
     gift_price      INT, 
     gift_money_coll INT, 
     gift_buyer_id   INT 
  ); 

INSERT INTO "gifts" 
            (gift_event_id, 
             gift_name, 
             gift_link, 
             gift_price, 
             gift_money_coll, 
             gift_buyer_id) 
VALUES      (2, 
             'iPhone 6 Plus', 
             'www.apple.com', 
             600, 
             300, 
             1); 

INSERT INTO "gifts" 
            (gift_event_id, 
             gift_name) 
VALUES      (2, 
             'MacBook Air'); 

CREATE TABLE comments 
  ( 
     id                SERIAL, 
     comments_event_id INT NOT NULL, 
     comments_gift_id  INT NOT NULL, 
     commenter_id      INT NOT NULL, 
     comment_time      TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
     comment_txt       CHAR(100) NOT NULL 
  ); 

INSERT INTO "comments" 
            (comments_event_id, 
             comments_gift_id, 
             commenter_id, 
             comment_txt) 
VALUES      (2, 
             1, 
             1, 
             'Ma ostsin ära selle, suht kallis asi ikka...'); 

CREATE TABLE users 
  ( 
     id                SERIAL, 
     e_mail CHAR(50) NOT NULL, 
     password  CHAR(50) NOT NULL 
  ); 