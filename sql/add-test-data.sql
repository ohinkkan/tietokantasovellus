INSERT INTO dbuser (username,password) VALUES
('dude','d00d'),
('chick','ch1ck');

INSERT INTO priority (name, importance, dbuser_id) VALUES
('zuper',8,1),
('nada',1,1),
('super',10,2),
('zippo',2,2);

INSERT INTO task (name,descr,priority_id,dbuser_id,done) VALUES
('workwork','work a lot',1,1,0),
('workwork2','work a lots',2,1,1),
('workwork3','work a lotz',2,1,0),
('workworkwork','work a loads',3,2,1),
('workworkworkwork','work a loooot',4,2,0);

INSERT INTO tasktype(name,dbuser_id) VALUES
('cleanup',1),
('terriblous',2);

INSERT INTO tasktype(name,dbuser_id,upper_id) VALUES
('cleanup2',1,1),
('terriblous2',2,2);

INSERT INTO typetasklink(task_id,tasktype_id) VALUES
(1,1),
(1,3),
(2,1),
(3,3),
(4,2),
(5,4);

