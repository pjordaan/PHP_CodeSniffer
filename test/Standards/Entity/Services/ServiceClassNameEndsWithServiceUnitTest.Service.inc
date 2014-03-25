<?php
namespace Ik\Ben\Een\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class MyService extends EntityRepository
{
    public function findByAap()
    {
        $a = $this->_em->findBy(["name" => "aap"]);
        $this->_em->flush();

        $this->flush();

        return $a;
    }

    private function flush()
    {
        return "aap";
    }

    private function flushTheToilet()
    {
        return "slush";
    }

    private
    function
          persist     ()
    {
        return "aap";
    }
}

class MyServiceTest extends \PHPUnit_Framework_TestCase {
}
