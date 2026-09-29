<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;

class CreateCompanyUsers extends Command
{
    protected $signature = 'companies:create-users';

    protected $description = 'Create or sync company users, assign user role and export login credentials';

    public function handle(): int
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->warn('No companies found.');

            return self::SUCCESS;
        }

        $rows = [
            [
                'Company ID',
                'Company Name',
                'Email',
                'Password',
                'Email Type',
            ],
        ];

        $created = 0;
        $existing = 0;
        $temporaryEmails = 0;
        $rolesAssigned = 0;
        $failed = 0;

        $this->info("Processing {$companies->count()} companies...");

        $bar = $this->output->createProgressBar($companies->count());
        $bar->start();

        foreach ($companies as $company) {
            try {
                DB::transaction(function () use (
                    $company,
                    &$rows,
                    &$created,
                    &$existing,
                    &$temporaryEmails,
                    &$rolesAssigned
                ) {
                    $companyName = trim(
                        $company->company_short_name ?: "Company {$company->id}"
                    );

                    $emailData = $this->resolveEmail($company);

                    if ($emailData['temporary']) {
                        $temporaryEmails++;
                    }

                    /*
                     * First try to find a user already attached
                     * to this company.
                     */
                    $user = $company->users()->first();

                    /*
                     * If no attached user exists, try finding
                     * one by email.
                     */
                    if (!$user) {
                        $user = User::where(
                            'email',
                            $emailData['address']
                        )->first();
                    }

                    /*
                     * Create the user only when no existing
                     * user could be found.
                     */
                    if (!$user) {
                        $user = User::create([
                            'name' => $companyName,
                            'email' => $emailData['address'],
                            'password' => Hash::make('12345678'),
                            'is_active' => true,
                        ]);

                        $created++;
                    } else {
                        $existing++;
                    }

                    /*
                     * Ensure the user is connected to the company.
                     */
                    $company->users()->syncWithoutDetaching([
                        $user->id,
                    ]);

                    /*
                     * Every company account must have the "user" role.
                     */
                    if (!$user->hasRole('user')) {
                        $user->assignRole('user');

                        $rolesAssigned++;
                    }

                    $rows[] = [
                        $company->id,
                        $companyName,
                        $user->email,
                        '12345678',
                        $emailData['temporary']
                            ? 'Temporary'
                            : 'Real',
                    ];
                });
            } catch (\Throwable $e) {
                $failed++;

                $this->newLine();

                $this->error(
                    "Company #{$company->id} failed: {$e->getMessage()}"
                );
            }

            $bar->advance();
        }

        $bar->finish();

        $this->newLine(2);

        $fileName = 'company-users-' .
            now()->format('Y-m-d-His') .
            '.xlsx';

        Excel::store(
            new class($rows) implements FromArray {
                public function __construct(
                    private array $rows
                ) {
                }

                public function array(): array
                {
                    return $this->rows;
                }
            },
            $fileName
        );

        $this->info('Company users synchronized successfully.');

        $this->newLine();

        $this->table(
            ['Result', 'Count'],
            [
                ['Companies', $companies->count()],
                ['Created users', $created],
                ['Existing users', $existing],
                ['Roles assigned', $rolesAssigned],
                ['Temporary emails', $temporaryEmails],
                ['Failed', $failed],
            ]
        );

        $this->newLine();

        $this->info(
            "Excel report: storage/app/{$fileName}"
        );

        return self::SUCCESS;
    }

    /**
     * Return the real company email or generate
     * a unique temporary email.
     */
    private function resolveEmail(Company $company): array
    {
        $email = strtolower(
            trim((string) $company->email)
        );

        if (
            $email !== '' &&
            filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            return [
                'address' => $email,
                'temporary' => false,
            ];
        }

        return [
            'address' => "company-{$company->id}@apec.local",
            'temporary' => true,
        ];
    }
}
