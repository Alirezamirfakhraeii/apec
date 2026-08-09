<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CompaniesExport;
use App\Features\Admin\Company\Actions\StoreCompanyAction;
use App\Features\Admin\Company\Actions\UpdateCompanyAction;
use App\Features\Admin\Company\DTOs\CompanyData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Company\StoreCompanyRequest;
use App\Http\Requests\Admin\Company\UpdateCompanyRequest;
use App\Models\ActivityField;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToArray;
use Throwable;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $totalCompanies = Company::query()->count();

        $query = Company::query()->with([
            'activityFields',
        ]);

        /*
        |--------------------------------------------------------------------------
        | جستجوی عمومی
        |--------------------------------------------------------------------------
        */

        if ($request->filled('q')) {
            $search = trim($request->input('q'));

            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('registered_name', 'like', "%{$search}%")
                    ->orWhere('company_short_name', 'like', "%{$search}%")
                    ->orWhere('company_name_en', 'like', "%{$search}%")
                    ->orWhere('national_id', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%")
                    ->orWhere('membership_number', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | فیلتر وضعیت عضویت
        |--------------------------------------------------------------------------
        */

        if ($request->filled('membership_status')) {
            $query->where(
                'membership_status',
                $request->input('membership_status')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | فیلتر نوع عضویت
        |--------------------------------------------------------------------------
        */

        if ($request->filled('membership_type')) {
            $query->where(
                'membership_type',
                $request->input('membership_type')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | فیلتر نوع فعالیت
        |--------------------------------------------------------------------------
        */

        if ($request->filled('activity_type')) {
            $query->where(
                'activity_type',
                'like',
                '%' . trim($request->input('activity_type')) . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | فیلتر تاریخ ثبت در سیستم
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->input('date_from')
            );
        }

        if ($request->filled('date_to')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->input('date_to')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | مرتب‌سازی
        |--------------------------------------------------------------------------
        */

        switch ($request->input('sort', 'name_asc')) {
            case 'latest':
                $query->latest();
                break;

            case 'oldest':
                $query->oldest();
                break;

            case 'name_desc':
                $query->orderByDesc('registered_name');
                break;

            case 'membership':
                $query->orderBy('membership_number');
                break;

            case 'name_asc':
            default:
                $query
                    ->orderByRaw('registered_name IS NULL')
                    ->orderBy('registered_name', 'asc');
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | تعداد نمایش
        |--------------------------------------------------------------------------
        */

        $allowedPerPages = [10, 20, 50, 100];

        $perPage = (int) $request->input('per_page', 10);

        if (! in_array($perPage, $allowedPerPages, true)) {
            $perPage = 10;
        }

        $companies = $query
            ->paginate($perPage)
            ->withQueryString();

        return view(
            'back.admin.companies.index',
            compact('companies', 'totalCompanies')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activityFields = ActivityField::query()
            ->where('is_active', true)
            ->orderByRaw("
            CASE section
                WHEN 'discipline' THEN 1
                WHEN 'work_field' THEN 2
                WHEN 'industry' THEN 3
                ELSE 4
            END
        ")
            ->orderBy('sort_order')
            ->get();

        return view('back.admin.companies.create', compact(
            'activityFields'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreCompanyRequest $request,
        StoreCompanyAction $storeCompanyAction
    ): RedirectResponse
    {
        try {
            $companyData = CompanyData::fromRequest($request);

            $company = $storeCompanyAction->execute($companyData);

            return redirect()
                ->route('admin.company.edit', $company)
                ->with(
                    'success',
                    'اطلاعات شرکت با موفقیت ثبت شد.'
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'خطایی هنگام ثبت اطلاعات شرکت رخ داد.'
                );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $activityFields = ActivityField::query()
            ->where('is_active', true)
            ->orderByRaw("
            CASE section
                WHEN 'discipline' THEN 1
                WHEN 'work_field' THEN 2
                WHEN 'industry' THEN 3
                ELSE 4
            END
        ")
            ->orderBy('sort_order')
            ->get();


        return view('back.admin.companies.edit', compact('company' , 'activityFields')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateCompanyRequest $request,
        Company $company,
        UpdateCompanyAction $updateCompanyAction
    ): RedirectResponse {
        try {
            $companyData = CompanyData::fromRequest($request);

            $updatedCompany = $updateCompanyAction->execute(
                $company,
                $companyData
            );

            return redirect()
                ->route('admin.company.edit', $updatedCompany)
                ->with(
                    'success',
                    'اطلاعات شرکت با موفقیت ویرایش شد.'
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'خطایی هنگام ویرایش اطلاعات شرکت رخ داد.'
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): RedirectResponse
    {
        try {
            $logoPath = $company->logo;

            DB::transaction(function () use ($company) {
                $company->delete();
            });

            if (
                $logoPath &&
                Storage::disk('public')->exists($logoPath)
            ) {
                Storage::disk('public')->delete($logoPath);
            }

            return redirect()
                ->route('admin.company.index')
                ->with(
                    'success',
                    'شرکت با موفقیت حذف شد.'
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                'خطایی هنگام حذف شرکت رخ داد.'
            );
        }
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:20480',
            ],
        ], [
            'excel_file.required' => 'لطفاً فایل اکسل را انتخاب کنید.',
            'excel_file.file' => 'فایل ارسال‌شده معتبر نیست.',
            'excel_file.mimes' => 'فرمت فایل باید xlsx، xls یا csv باشد.',
            'excel_file.max' => 'حجم فایل نباید بیشتر از ۲۰ مگابایت باشد.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | نرمال‌سازی اعداد فارسی و عربی
        |--------------------------------------------------------------------------
        */

        $convertDigits = static function ($value) {
            if ($value === null) {
                return null;
            }

            return strtr((string) $value, [
                '۰' => '0',
                '۱' => '1',
                '۲' => '2',
                '۳' => '3',
                '۴' => '4',
                '۵' => '5',
                '۶' => '6',
                '۷' => '7',
                '۸' => '8',
                '۹' => '9',

                '٠' => '0',
                '١' => '1',
                '٢' => '2',
                '٣' => '3',
                '٤' => '4',
                '٥' => '5',
                '٦' => '6',
                '٧' => '7',
                '٨' => '8',
                '٩' => '9',
            ]);
        };

        /*
        |--------------------------------------------------------------------------
        | نرمال‌سازی عنوان ستون اکسل
        |--------------------------------------------------------------------------
        |
        | عنوان بعضی ستون‌ها چندخطی است. این تابع Enter، Tab، نیم‌فاصله
        | و فاصله‌های اضافی را حذف می‌کند.
        |
        */

        $normalizeHeader = static function ($header): string {
            $header = trim((string) $header);

            $header = str_replace(
                [
                    "\r",
                    "\n",
                    "\t",
                    "\u{200C}",
                    "\u{200D}",
                    "\u{200E}",
                    "\u{200F}",
                ],
                ' ',
                $header
            );

            $header = str_replace(
                ['ي', 'ك'],
                ['ی', 'ک'],
                $header
            );

            return trim(
                preg_replace('/\s+/u', ' ', $header)
            );
        };

        /*
        |--------------------------------------------------------------------------
        | نرمال‌سازی مقدارهای بله و خیر
        |--------------------------------------------------------------------------
        */

        $normalizeBoolean = static function ($value) use ($convertDigits): ?bool {
            if ($value === null) {
                return null;
            }

            if (is_bool($value)) {
                return $value;
            }

            $value = $convertDigits($value);
            $value = trim(mb_strtolower((string) $value));

            if ($value === '') {
                return null;
            }

            $trueValues = [
                '1',
                'true',
                'yes',
                'y',
                'بله',
                'بلی',
                'دارد',
                'دارای',
                'هست',
                'می باشد',
                'می‌باشد',
                '✓',
                '✔',
                'x',
            ];

            $falseValues = [
                '0',
                'false',
                'no',
                'n',
                'خیر',
                'نه',
                'ندارد',
                'فاقد',
                'نیست',
                '✗',
                '×',
            ];

            if (in_array($value, $trueValues, true)) {
                return true;
            }

            if (in_array($value, $falseValues, true)) {
                return false;
            }

            return null;
        };

        /*
        |--------------------------------------------------------------------------
        | اتصال عنوان ستون‌های اکسل به ستون‌های جدول companies
        |--------------------------------------------------------------------------
        */

        $columnMap = [
            // اطلاعات پایه
            'نام اختصاری/شناخته شده شرکت' => 'company_short_name',
            'نام ثبتی' => 'registered_name',
            'کارت عضویت' => 'membership_card',
            'Company Name' => 'company_name_en',
            'تابعیت' => 'nationality',

            // اطلاعات ثبتی
            'تاریخ ثبت' => 'registration_date',
            'شماره ثبت' => 'registration_number',
            'محل ثبت' => 'registration_place',
            'شناسه ملی' => 'national_id',
            'سرمایه ثبتی (ریال)' => 'registered_capital_irr',
            'نام شرکت مادر (در صورت وجود)' => 'parent_company_name',
            'نوع شرکت (سهامی عام/خاص/مسوولیت محدود/سایر)' => 'company_type',

            // اطلاعات تماس
            'تلفن' => 'phone',
            'فاکس' => 'fax',
            'ایمیل' => 'email',
            'سایت' => 'website',
            'آدرس' => 'address',

            // مدیرعامل
            'مدیر عامل' => 'ceo_name',
            'شماره موبایل مدیر عامل' => 'ceo_mobile',
            'آدرس ایمیل مدیر عامل' => 'ceo_email',

            // رئیس هیئت‌مدیره
            'نام رییس هیئت مدیره' => 'chairman_name',
            'شماره موبایل رییس هیئت مدیره' => 'chairman_mobile',
            'آدرس ایمیل رییس هیئت مدیره' => 'chairman_email',

            // روزنامه رسمی
            'تاریخ روزنامه مورد استناد' => 'reference_gazette_date',

            // رابط انجمن
            'نماینده رابط انجمن' => 'association_contact_name',
            'سمت سازمانی' => 'association_contact_position',
            'شماره موبایل رابط انجمن' => 'association_contact_mobile',
            'آدرس ایمیل رابط انجمن' => 'association_contact_email',

            // اطلاعات عضویت
            'تاریخ عضویت در انجمن' => 'association_join_date',
            'شماره عضویت' => 'membership_number',
            'نوع عضویت (اصلی/وابسته)' => 'membership_type',
            'وضعیت عضویت (فعال/تعلیق/لغو)' => 'membership_status',
            'توضیحات وضعیت عضویت 1403' => 'membership_status_notes_1403',
            'همکاری با کدام یک از کمیته های انجمن' => 'association_committees',

            // کارت بازرگانی
            'آیا کارت بازرگانی معتبر دارد؟' => 'has_valid_commercial_card',
            'تاریخ اعتبار کارت بازرگانی' => 'commercial_card_valid_until',

            // کارت عضویت اتاق بازرگانی
            'آیا کارت عضویت معتبر اتاق بازرگانی را دارد؟'
            => 'has_valid_chamber_membership_card',

            'تاریخ اعتبار گواهینامه عضویت بازرگانی'
            => 'chamber_membership_valid_until',

            'عضو اتاق کدام استان می باشد؟'
            => 'chamber_province',

            // حوزه‌های فعالیت
            'طراحی و مشاوره' => 'activity_design_consulting',
            'C (ساختمان، نصب و راه اندازی)'
            => 'activity_construction_installation',
            'EPC' => 'activity_epc',
            'MC' => 'activity_mc',
            'تولید' => 'activity_manufacturing',

            // نوع فعالیت
            'نوع فعالیت' => 'activity_type',
        ];

        /*
        |--------------------------------------------------------------------------
        | نرمال‌سازی کلیدهای Map
        |--------------------------------------------------------------------------
        */

        $normalizedColumnMap = [];

        foreach ($columnMap as $excelColumn => $databaseColumn) {
            $normalizedColumnMap[
            $normalizeHeader($excelColumn)
            ] = $databaseColumn;
        }

        try {
            /*
            |--------------------------------------------------------------------------
            | خواندن فایل اکسل
            |--------------------------------------------------------------------------
            */

            $arrayImport = new class implements ToArray {
                public function array(array $array)
                {
                    // خروجی توسط Excel::toArray دریافت می‌شود.
                }
            };

            $sheets = Excel::toArray(
                $arrayImport,
                $request->file('excel_file')
            );

            $rows = $sheets[0] ?? [];



            if (count($rows) < 2) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'excel_file' => 'فایل اکسل خالی است یا ردیف اطلاعات ندارد.',
                    ]);
            }


            /*
            |--------------------------------------------------------------------------
            | دریافت ردیف عنوان‌ها
            |--------------------------------------------------------------------------
            */

            $headers = array_map(
                $normalizeHeader,
                $rows[0]
            );

            $insertedCount = 0;
            $updatedCount = 0;
            $skippedCount = 0;

            /*
            |--------------------------------------------------------------------------
            | ستون‌های Boolean
            |--------------------------------------------------------------------------
            */

            $booleanColumns = [
                'has_valid_commercial_card',
                'has_valid_chamber_membership_card',
                'activity_design_consulting',
                'activity_construction_installation',
                'activity_epc',
                'activity_mc',
                'activity_manufacturing',
            ];

            DB::transaction(function () use (
                $rows,
                $headers,
                $normalizedColumnMap,
                $normalizeBoolean,
                $convertDigits,
                $booleanColumns,
                &$insertedCount,
                &$updatedCount,
                &$skippedCount
            ) {
                /*
                |--------------------------------------------------------------------------
                | شروع از ردیف دوم اکسل
                |--------------------------------------------------------------------------
                */

                foreach (array_slice($rows, 1) as $row) {
                    /*
                    |--------------------------------------------------------------------------
                    | نادیده گرفتن ردیف کاملاً خالی
                    |--------------------------------------------------------------------------
                    */

                    $hasAnyValue = collect($row)->contains(
                        static function ($value) {
                            return $value !== null &&
                                trim((string) $value) !== '';
                        }
                    );

                    if (! $hasAnyValue) {
                        continue;
                    }

                    $data = [];

                    /*
                    |--------------------------------------------------------------------------
                    | اتصال هر سلول به ستون دیتابیس
                    |--------------------------------------------------------------------------
                    */

                    foreach ($headers as $index => $header) {
                        if ($header === '') {
                            continue;
                        }

                        if (! isset($normalizedColumnMap[$header])) {
                            continue;
                        }

                        $databaseColumn = $normalizedColumnMap[$header];
                        $value = $row[$index] ?? null;

                        if (is_string($value)) {
                            $value = trim($value);
                        }

                        if ($value === '') {
                            $value = null;
                        }

                        $data[$databaseColumn] = $value;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | اگر هیچ ستون معتبری پیدا نشد
                    |--------------------------------------------------------------------------
                    */

                    if (empty($data)) {
                        $skippedCount++;
                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | تبدیل اعداد فارسی و عربی به انگلیسی
                    |--------------------------------------------------------------------------
                    */

                    $digitColumns = [
                        'national_id',
                        'registration_number',
                        'membership_number',
                        'phone',
                        'fax',
                        'ceo_mobile',
                        'chairman_mobile',
                        'association_contact_mobile',
                    ];

                    foreach ($digitColumns as $column) {
                        if (
                            array_key_exists($column, $data) &&
                            $data[$column] !== null
                        ) {
                            $data[$column] = trim(
                                $convertDigits($data[$column])
                            );
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | پاک‌سازی سرمایه ثبتی
                    |--------------------------------------------------------------------------
                    */

                    if (
                        array_key_exists('registered_capital_irr', $data) &&
                        $data['registered_capital_irr'] !== null
                    ) {
                        $registeredCapital = $convertDigits(
                            $data['registered_capital_irr']
                        );

                        $registeredCapital = preg_replace(
                            '/[^\d]/',
                            '',
                            $registeredCapital
                        );

                        $data['registered_capital_irr'] =
                            $registeredCapital !== ''
                                ? $registeredCapital
                                : null;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | تبدیل مقادیر بله/خیر به Boolean
                    |--------------------------------------------------------------------------
                    */

                    foreach ($booleanColumns as $booleanColumn) {
                        if (array_key_exists($booleanColumn, $data)) {
                            $data[$booleanColumn] = $normalizeBoolean(
                                $data[$booleanColumn]
                            );
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | پاک‌سازی شناسه ملی
                    |--------------------------------------------------------------------------
                    */

                    if (! empty($data['national_id'])) {
                        $data['national_id'] = preg_replace(
                            '/\s+/u',
                            '',
                            (string) $data['national_id']
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | حداقل اطلاعات لازم برای ثبت
                    |--------------------------------------------------------------------------
                    */

                    if (
                        empty($data['registered_name']) &&
                        empty($data['national_id'])
                    ) {
                        $skippedCount++;
                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | ثبت یا به‌روزرسانی براساس شناسه ملی
                    |--------------------------------------------------------------------------
                    */

                    if (! empty($data['national_id'])) {
                        $existingCompany = Company::query()
                            ->where('national_id', $data['national_id'])
                            ->first();

                        if ($existingCompany) {
                            $existingCompany->update($data);
                            $updatedCount++;

                            continue;
                        }

                        Company::create($data);
                        $insertedCount++;

                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | شرکت‌هایی که شناسه ملی ندارند
                    |--------------------------------------------------------------------------
                    */

                    Company::create($data);
                    $insertedCount++;
                }
            });

            return redirect()
                ->route('admin.company.index')
                ->with(
                    'success',
                    "ورود فایل اکسل با موفقیت انجام شد. "
                    ."{$insertedCount} عضو ثبت شد، "
                    ."{$updatedCount} عضو به‌روزرسانی شد و "
                    ."{$skippedCount} ردیف نادیده گرفته شد."
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'excel_file' => 'خطایی هنگام خواندن یا ثبت فایل اکسل رخ داد: '
                        .$exception->getMessage(),
                ]);
        }
    }


    public function export()
    {
        return Excel::download(new CompaniesExport(), 'companies.xlsx');
    }

}




