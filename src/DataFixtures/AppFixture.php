<?php

namespace App\DataFixtures;

use App\Entity\Attachments;
use App\Entity\Experiences;
use App\Entity\Projects;
use App\Entity\Tools;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixture extends Fixture
{
    private $cypher;

    const EXPERIENCES = [
        [
            'label' => 'Wild Code School',
            'description' => 'Formation développeur web et mobile. Mise en place de projets PHP Symfony',
            'startedAt' => '2019',
            'endedAt' => null,
        ],
        [
            'label' => 'Stormshield, Lyon',
            'description' => 'Prise en charge d\'incidents de niveau1 et 2 sur des firewalls Stormshield et Arkoon',
            'startedAt' => '2017',
            'endedAt' => '2019',
        ],
        [
            'label' => 'Cegid, Lyon',
            'description' => 'Support de niveau 1, 2 et 3 d\'une solution d\'encaissement',
            'startedAt' => '2016',
            'endedAt' => '2017',
        ],

    ];


    const ATTACHMENTS = [

        [
            'label' => 'Eggsplosive',
            'path' => '/assets/img/eggsplosive.jpg',
            'color' => 'dark'
        ],
        [
            'label' => 'BnB Around the World',
            'path' => '/assets/img/bnbAroundTheWorld.jpg',
            'color' => 'light'
        ],
        [
            'label' => 'Bookmark',
            'path' => '/assets/img/bookmark.jpg',
            'color' => 'dark'
        ],

        [
            'label' => 'Nasa\'s pictures',
            'path' => '/assets/img/nasaSPicture.jpg',
            'color' => 'light'
        ],
        [
            'label' => 'BeeTools',
            'path' => '/assets/img/beeTools.jpg',
            'color' => 'dark'
        ],
    ];

    const TOOLS = [

        ['label' => 'PHP', 'color' => 'red', 'mastery' => 96],
        ['label' => 'Symphony', 'color' => 'red', 'mastery' => 95],
        ['label' => 'Python', 'color' => 'red', 'mastery' => 80],
        ['label' => 'Java', 'color' => 'red', 'mastery' => 70],
        ['label' => 'HTML', 'color' => 'yellow', 'mastery' => 92],
        ['label' => 'CSS', 'color' => 'yellow', 'mastery' => 90],
        ['label' => 'Javascript', 'color' => 'yellow', 'mastery' => 85],
        ['label' => 'React', 'color' => 'yellow', 'mastery' => 75],
        ['label' => 'VueJs', 'color' => 'yellow', 'mastery' => 76],
        ['label' => 'TCP/IP', 'color' => 'blue', 'mastery' => 90],
        ['label' => 'Firewall', 'color' => 'blue', 'mastery' => 92],
        ['label' => 'Linux', 'color' => 'blue', 'mastery' => 94],
        ['label' => 'Windows', 'color' => 'blue', 'mastery' => 87],
        ['label' => 'BSD', 'color' => 'blue', 'mastery' => 92]
    ];

    const PROJECTS = [

        [
            'title' => 'Eggsplosive',
            'link' => 'https://github.com/tleon/eggsplosive',
            'tools' => [6]
        ],
        [
            'title' => 'BnB Around the World',
            'link' => 'https://github.com/tleon/BnbAroundTheWorld',
            'tools' => [0, 1, 2]
        ],
        [
            'title' => 'Bookmark',
            'link' => 'https://github.com/tleon/bookmark',
            'tools' => [2, 7]
        ],

        [
            'title' => 'Nasa\'s pictures',
            'link' => 'https://github.com/tleon/Nasa-s-pictures',
            'tools' => [4]
        ],
        [
            'title' => 'BeeTools',
            'link' => 'https://github.com/tleon/beeTools',
            'tools' => [8]
        ],

    ];

    public function __construct(UserPasswordEncoderInterface $cypher)
    {
        $this->cypher = $cypher;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        //User
        $user = new Users();
        $user->setUsername('thomas.leone');
        $user->setBackgroundImgPath('/assets/img/002.jpg');
        $user->setEmail('leone.thomas.92@gmail.com');
        $user->setPassword($this->cypher->encodePassword($user, 'azerty'));
        $user->setGithubLink('https://github.com/tleon');
        $user->setPhone('07 88 44 39 49');
        $user->setSpecialty('Développeur web PHP Symfony');
        $manager->persist($user);

        //Experiences
        foreach (self::EXPERIENCES as $exp) {
            $experience = new Experiences();
            $experience->setLabel($exp['label']);
            $experience->setDescription(($exp['description']));
            $experience->setStartedAt($exp['startedAt']);
            $experience->setEndedAt($exp['endedAt']);
            $experience->setUser($user);
            $manager->persist($experience);
        }

        //Attachments
        foreach (self::ATTACHMENTS as $k => $att) {
            $attachment = new Attachments();
            $attachment->setLabel($att['label']);
            $attachment->setPath($att['path']);
            $attachment->setTextColor($att['color']);
            $manager->persist($attachment);
            $this->setReference('attachment_' . $k, $attachment);
        }

        //Tools

        foreach (self::TOOLS as $k => $t) {
            $tool = new Tools();
            $tool->setLabel($t['label']);
            $tool->setColor($t['color']);
            $tool->setMastery($t['mastery']);
            $manager->persist($tool);
            $this->setReference('tool_' . $k, $tool);
        }

        //Projects

        foreach (self::PROJECTS as $k => $p) {
            $project = new Projects();
            $project->setTitle($p['title']);
            $project->setLink($p['link']);
            foreach ($p['tools'] as $language) {
                $project->addTool($this->getReference('tool_' . $language));
            }
            $project->setUser($user);
            $project->setAttachment($this->getReference('attachment_' . $k));
            $manager->persist($project);
        }

        $manager->flush();
    }
}
