<?php

require_once 'Repository.php';
require_once __DIR__ . "/../models/UserProfile.php";

class ProfilesRepository extends Repository
{
    public function getProfiles(int $user_account_id): ?array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare(
            "SELECT user_account.id   as user_id,
       user_account.name as name,
       bio,
       birthday,
       photo,
       g.name            as gender
FROM user_account
         join gender g on gender_id = g.id
         join user_photo up on user_account.id = up.user_account_id
where user_account.id != :user_account_id
  and user_account.id not in (select target_user_id from match where user_account_id = :user_account_id);"
        );
        $stmt->bindParam(':user_account_id', $user_account_id, PDO::PARAM_INT);
        $stmt->execute();

        $userProfiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userProfiles as $userProfile) {
            $result[] = new UserProfile(
                $userProfile['user_id'],
                $userProfile['name'],
                $userProfile['bio'],
                $userProfile['birthday'],
                $userProfile['photo'],
                $userProfile['gender'],
            );
        }
        return $result;
    }

    public function giveLike($userId, $receiverId)
    {
        $stmt = $this->database->connect()->prepare('INSERT INTO match (user_account_id, target_user_id) values (?, ?)');

        $stmt->execute([
            $userId,
            $receiverId
        ]);
        $stmt = $this->database->connect()->prepare('insert into conversation (id, user_account_id)
select id, user1
from vmatches_with_id
where not exists(select *
                 from vallconversations
                 where vmatches_with_id.user1 = cuser1 and vmatches_with_id.user2 = cuser2) order by id desc limit 1;');
        $stmt->execute();
        $stmt = $this->database->connect()->prepare('
insert into participant (conversation_id, user_account_id)
SELECT id, user2
from vmatches_with_id order by id desc limit 1;
');
        $stmt->execute();

    }
}