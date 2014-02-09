CREATE TABLE dbuser
(
id SERIAL PRIMARY KEY,
username VARCHAR(30) UNIQUE,
password VARCHAR(30)
);

CREATE TABLE priority
(
id SERIAL PRIMARY KEY,
name VARCHAR(30),
importance INTEGER,
dbuser_id INTEGER REFERENCES dbuser(id) ON DELETE cascade ON UPDATE cascade
);

CREATE TABLE task
(
id SERIAL PRIMARY KEY,
name VARCHAR(30),
descr VARCHAR(255),
priority_id INTEGER REFERENCES priority(id) ON DELETE set null ON UPDATE cascade,
dbuser_id INTEGER REFERENCES dbuser(id) ON DELETE cascade ON UPDATE cascade,
done INTEGER
);

CREATE TABLE tasktype
(
id SERIAL PRIMARY KEY,
name VARCHAR(30),
dbuser_id INTEGER REFERENCES dbuser(id) ON DELETE cascade ON UPDATE cascade
);

ALTER TABLE tasktype
ADD upper_id INTEGER REFERENCES tasktype(id) ON DELETE set null ON UPDATE cascade;

CREATE TABLE typetasklink
(
task_id INTEGER REFERENCES task(id) ON DELETE cascade ON UPDATE cascade,
tasktype_id INTEGER REFERENCES tasktype(id) ON DELETE cascade ON UPDATE cascade
);


