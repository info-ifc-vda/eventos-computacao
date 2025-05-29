<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenApi\Attributes as OA;
use OpenApi\Generator;


#[OA\OpenApi(
    info: new OA\Info(
        title: "Eventos Computação",
        description: "API da plataforma de gerenciamento de eventos desenvolvida pela turma de Ciência da Computação 2023 - IFC Videira",
        license: new OA\License(
            name: "MIT license",
            url: "https://mit-license.org/",
            identifier: "MIT"
        ),
        version: "0.0.1"),
    // servers: [
    //     "https://eventos.fsw-ifc.brdrive.cloud/api/v1",
    //     "https://eventos.fsw-ifc.brdrive.localhost/api/v1"
    // ],
    )]
class GenerateDocs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera os arquivos openapi.json';

    /**
     * Execute the console command.
     *
     * @return int
     */
    #[OA\Parameter(
        parameter: 'per_page',
        name: 'per_page',
        description: 'Quantidade de registros por página',
        in: 'query',
        required: false,
        schema: new OA\Schema(
            type: 'integer',
            default: 10,
        )
    ),
    OA\Parameter(
        parameter: 'page',
        name: 'page',
        description: 'Página dos registros',
        in: 'query',
        required: false,
        schema: new OA\Schema(
            type: 'integer',
            default: 1,
        )
    )
    ]
    public function handle()
    {
        $generator = new Generator();

        $generator->generate([
            __DIR__,
            __DIR__.'/../../Http/Controllers',
            __DIR__.'/../../Http/Requests',
            __DIR__.'/../../Http/Resources',
            __DIR__.'/../../../routes'
        ])->saveAs(__DIR__.'/../../../resources/swagger/openapi.json');

        return Command::SUCCESS;
    }
}
