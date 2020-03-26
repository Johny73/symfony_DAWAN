<?php

namespace App\Security\Voter;

use App\Entity\BoardGame;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BoardGameVoter extends Voter
{
    protected function supports($attribute, $subject)
    {

        return $attribute === 'GAME_EDIT'
            && $subject instanceof \App\Entity\BoardGame;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        /** @var BoardGame $subject */
        If ($subject->getAuthorIs() === $user){
            return true;
        }

        return false;
    }
}
