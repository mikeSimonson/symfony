<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\FrameworkBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Workflow\Dumper\GraphvizDumper;
use Symfony\Component\Workflow\Marking;

/**
 * A console command for retrieving information about services.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class WorkflowDumpCommand extends ContainerAwareCommand
{
    public function isEnabled()
    {
        return $this->getContainer()->has('workflow.registry');
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('workflow:dump')
            ->setDefinition(array(
                new InputArgument('name', InputArgument::REQUIRED, 'A workflow name'),
                new InputArgument('marking', InputArgument::IS_ARRAY, 'A marking (a list of place)'),
            ))
            ->setDescription('Dump a workflow')
            ->setHelp(<<<'EOF'
The <info>%command.name%</info> command dump an dot representation of a workflow.

    %command.full_name% <workflow name> | dot -Tpng > workflow.png

EOF
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $workflow = $this->getContainer()->get('workflow.'.$input->getArgument('name'));
        $definition = $this->getProperty($workflow, 'definition');

        $dumper = new GraphvizDumper();

        $marking = new Marking();
        foreach ($input->getArgument('marking') as $place) {
            $marking->mark($place);
        }

        $output->writeln($dumper->dump($definition, $marking));
    }

    private function getProperty($object, $property)
    {
        $reflectionProperty = new \ReflectionProperty(get_class($object), $property);
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty->getValue($object);
    }
}
