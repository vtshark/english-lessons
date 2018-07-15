<?php

namespace App\Command;

use App\Entity\Word;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportWordsCommand extends Command
{
    protected static $defaultName = 'import-words';
    private $em;

    /**
     * ImportWordsCommand constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Import of translations from a file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
//        $arg1 = $input->getArgument('arg1');

//        if ($arg1) {
//            $io->note(sprintf('You passed an argument: %s', $arg1));
//        }

//        if ($input->getOption('option1')) {
//            // ...
//        }

        $arr_data = $this->readFile();
        foreach($arr_data as $item) {
            $this->saveItem($item["eng"], $item["rus"], $item["description"]);
        }
        $this->em->flush();
        $io->success('Data import completed. Processed  ' . count($arr_data) . ' records.');
    }

    private function saveItem($eng, $rus, $description) {
        $repository = $this->em->getRepository(Word::class);
        $word = $repository->findOneBy(['eng' => $eng]);
        if (!$word) {
            $word = new Word();
        }
        $word->setEng($eng);
        $word->setRus($rus);
        $word->setDescription($description);
        $this->em->persist($word);
    }

    private function readFile() {
        $content = file_get_contents('%kernel.root_dir%/../src/Data/words.csv');
        $content_array = explode("\n", $content);
        $content_array = array_diff($content_array, ['']);

        $result = [];
        foreach ($content_array as $item) {
            $item_arr = explode(",", $item);

            $result[] = [
                'eng' => str_replace("\"","",$item_arr[1]),
                'rus' => str_replace("\"","",$item_arr[2]),
                'description' => str_replace("\"","",$item_arr[3]),
                ]
            ;
        }

        return $result;
    }

}
