<?php

namespace App\Test\Controller;

use App\Entity\Leçon;
use App\Repository\LeçonRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LeçonControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private LeçonRepository $repository;
    private string $path = '/le/on/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Leçon::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Leçon index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'le_on[titre]' => 'Testing',
            'le_on[contenuCours]' => 'Testing',
            'le_on[apprenants]' => 'Testing',
        ]);

        self::assertResponseRedirects('/le/on/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Leçon();
        $fixture->setTitre('My Title');
        $fixture->setContenuCours('My Title');
        $fixture->setApprenants('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Leçon');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Leçon();
        $fixture->setTitre('My Title');
        $fixture->setContenuCours('My Title');
        $fixture->setApprenants('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'le_on[titre]' => 'Something New',
            'le_on[contenuCours]' => 'Something New',
            'le_on[apprenants]' => 'Something New',
        ]);

        self::assertResponseRedirects('/le/on/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getContenuCours());
        self::assertSame('Something New', $fixture[0]->getApprenants());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Leçon();
        $fixture->setTitre('My Title');
        $fixture->setContenuCours('My Title');
        $fixture->setApprenants('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/le/on/');
    }
}
