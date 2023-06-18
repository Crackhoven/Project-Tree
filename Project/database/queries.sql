-- select all users which are the mentee of a mentor
select *
from mentees
    join users on users.id = mentees.fk_user_id
where fk_mentor_id = 1;
-- select current mentor of a mentee
select users.*
from mentees
    join users on users.id = mentees.fk_mentor_id
where fk_user_id = 2;
-- search function
-- select all mentors with the skill 'data science'
select *
from skills
    join user_skills on skills.id = fk_skill_id
    join users on users.id = user_skills.fk_user_id
    join mentors on users.id = mentors.fk_user_id
where name = 'data-science'
-- select details of specific user
select *
from users
where id = 1;
-- select reviews for specific mentor
select users.first_name,
    users.last_name,
    date,
    subject,
    details,
    rating
from user_reviews
    join mentees on user_reviews.fk_mentee_id = mentees.id
    join users on mentees.fk_user_id = users.id
where user_reviews.fk_mentor_id = 1;
-- has the mentee any active or pending (status < 2) applications
select *
from applications
where fk_mentee_id = 2
    and status < 2;
-- select all mentees who have are either pending or accepted inventations by a specific mentor
select applications.status,
    users.*
from applications
    join mentees on mentees.id = applications.fk_mentee_id
    join users on users.id = mentees.fk_user_id
where applications.fk_mentor_id = 2
    and status < 2
-- last insert id
select last_insert_id();
-- select all skills of user
select name from skills
    join user_skills on skills.id = fk_skill_id
    join users on users.id = user_skills.fk_user_id
where users.id = 2; -- limit 5
-- select all social media of user
select social_media_platforms.name, user_social_media.username, social_media_platforms.website from user_social_media
    join social_media_platforms on user_social_media.fk_platform_id = social_media_platforms.id
where user_social_media.fk_user_id = 1;
-- is mentee already connected to specfic mentor
select * from mentors
join users on mentors.fk_user_id = users.id
join mentees on mentors.id = mentees.fk_mentor_id
where users.id = 1
and mentees.fk_user_id = 2;

-- select count and average rating of reviews
select count(1), avg(rating)
from user_reviews
    join mentees on user_reviews.fk_mentee_id = mentees.id
    join users on mentees.fk_user_id = users.id
where user_reviews.fk_mentor_id = 1;