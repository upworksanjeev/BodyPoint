<?php

namespace App\Http\Controllers;

use App\Mail\vaultMail;
use App\Models\AssociateCustomer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Media;
use App\Models\User;
use App\Services\SysproService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Display the category details.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        if (isset($categories)) {
            $products = Product::with(['media'])->paginate(16);

            if (!empty(auth()->user()->default_customer_id)) {
                $url = 'ListStock';
                SysproService::listStock($url);
            }

            return view('front', [
                'categories' => $categories,
                'products' => $products,
            ]);
        } else {
            return view('front', [
                'error' => 'No Products Found!'
            ]);
        }
    }

    public function changeCustomer(Request $request)
    {
        $request->validate([
            'customer_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existsInUsers = User::where('default_customer_id', $value)
                        ->orWhereHas('associateCustomers', function ($query) use ($value) {
                            $query->where('customer_id', $value);
                        })->exists();
                    if (!$existsInUsers) {
                        $fail('The selected customer ID does not exist.');
                    }
                },
            ],
        ]);
        try {
            //session()->put('customer_id', $request->customer_id);
            $customer_id = $request->customer_id;
            $url = 'GetCustomerDetails/' . $customer_id;
            $get_customer_details = SysproService::getCustomerDetails($url);
          
            if ($get_customer_details) {
                session()->put('customer_id', $request->customer_id);
                session()->put('customer_details', $get_customer_details);
                session()->put('customer_address', $get_customer_details['ShipToAddresses'][0]);
                $customerClass = $get_customer_details['CustomerClass'] ?? '';

            
                $authUser = Auth::user();
                if ($customerClass === "") {
                    if (!$authUser->hasRole('Public User')) {
                        $authUser->assignRole('Public User');
                    }
                } else {
                    if (!$authUser->hasRole($customerClass)) {
                        $authUser->assignRole($customerClass);
                    }
                }
                $customer = AssociateCustomer::where([
                    ['user_id', Auth::id()],
                    ['customer_id', $customer_id]
                ])->first();
                if ($customer) {
                    if ($get_customer_details['CustomerClass'] == "") {
                        if (!$customer->hasRole('Public User')) {
                            $customer->assignRole('Public User');
                        }
                    }
                    if (!$customer->hasRole($get_customer_details['CustomerClass'])) {
                        $customer->assignRole($get_customer_details['CustomerClass']);
                    }
                }
                
                return Response::json(['success' => true, 'message' => 'Customer Changed Successfully']);
            } else {
                return Response::json(['success' => false, 'message' => 'Customer not found']);
            }
        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function getFrequentlyUserFiles()
    {
        return
            [
                [
                    'name' => 'Product Guide',
                    //'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Catalog_product_guide_BMM002_Volume_8.4_HI_RES.pdf',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2025/01/product-guide-catalog.pdf',
                ],
                [
                    'name' => 'Dynamic Arm Support Brochure',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Dynamic-Arm-Support-Brochure-BMM343-2022.4.pdf',
                ],
                [
                    'name' => 'Essential Hip Belt Sell Sheet',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Essentials_Hip_Belt_Sell_Sheet_-BMM337_2023.4.pdf',
                ],
            ];
    }

    private function getNewlyAdded()
    {
        return
            [
                [
                    'name' => 'Trifold Brochure',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Trifold-Brochure-BMM347-2024.02.pdf',
                ],
            ];
    }
    private function getPresentations()
    {
        return
            [
                [
                    'name' => '1-New Bodypoint Intro',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/1-New-Bodypoint-Intro.pptx',
                ],
                [
                    'name' => '2-Product Overview',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/2-Product-Overview.pptx',
                ],
                [
                    'name' => '3-Pelvic Positioning',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/3-Pelvic-Positioning.pptx',
                ],
                [
                    'name' => '4-Upper Body Support',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/4-Upper-Body-Support.pptx',
                ],
                [
                    'name' => '5-Lower Body Accessories Power',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/5-Lower-Body-Accessories-Power.pptx',
                ],
                [
                    'name' => '6-Bath and Shower Product',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/6-Bath-and-Shower-Product.pptx',
                ],
                [
                    'name' => 'Essentials 2022INTL',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Essentials-2022INTL.pptx',
                ],
                [
                    'name' => 'Essentials 2022 USA',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Essentials-2022-USA.pptx',
                ],
            ];
    }

    private function getPricingGuide()
    {
        return
            [
                [
                    'name' => 'Americas',
                    //'url' => 'https://bodypoint.com/wp-content/uploads/2024/12/Bodypoint-2025-Dealer-Price-List-AMERICAS.xlsx',
                    'url' => asset('storage/pricing/Bodypoint-2025-Dealer-Price-List-AMERICAS.xlsx'),
                ],
                [
                    'name' => 'International',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/12/Bodypoint-2025-Dealer-Price-List-INTERNATIONAL.xlsx',
                ],
                [
                    'name' => 'Dealer Price List',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/12/Dealer-Price-List_BPMC204_2024.pdf',
                ],
                [
                    'name' => 'Retail Price List',
                    'url' => 'https://bodypoint.com/wp-content/uploads/2024/12/Retail_Price_List_BPMC301_2024.pdf',
                ],
            ];
    }

    private function getProductAndTechnical()
    {
        return
            [
                'Product Instructions' => [
                    'Product Instruction Archive' => [
                        [
                            'name' => 'BPI060 Stayflex rear pull',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI060_Stayflex_rear-pull-2.pdf',
                        ],
                        [
                            'name' => 'BPI063 Stayflex front pull',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI063_Stayflex_front-pull-1.pdf',
                        ],
                        [
                            'name' => 'BPI099 PivoFit front pull',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI099_PivoFit_front-pull-1.pdf',
                        ],
                        [
                            'name' => 'BPI096 Pivotfit rear pull',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI096_Pivotfit_rear-pull-1.pdf',
                        ],

                    ],
                    'Specialty Product Instructions' => [
                        [
                            'name' => 'BPI103 Mobility Bag',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI103_Mobility_Bag_2021.2-1.pdf',
                        ],

                    ],
                    'Power Chair Instructions' => [
                        [
                            'name' => 'BPI025 Joystick Handle',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI025_Joystick_Handle_2021.10-1.pdf',
                        ],

                    ],
                    'Lower Body Instructions' => [
                        [
                            'name' => 'BPI055 Aeromesh Calf Strap and Calf Panel',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI055_Aeromesh_Calf_Strap_and_Calf_Panel_2021.10-1.pdf',
                        ]

                    ],
                    'Upper Body Instructions' => [
                        [
                            'name' => 'BPI007 Trimline Shoulder Harness',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI007_Trimline_Shoulder_Harness_2021.2-2.pdf',
                        ],
                        [
                            'name' => 'BPI064 Stayflex Anterior Trunk Support',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI064_Stayflex_Anterior_Trunk_Support_2021.2-1.pdf',
                        ],
                        [
                            'name' => 'BPI066 PivotFit Shoulder Harness',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI066_PivotFit_Shoulder_Harness_2021.2-1.pdf',
                        ],
                        [
                            'name' => 'BPI073 Sub ASIS-Pad',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI073_Sub_ASIS-Pad_2021.10-1.pdf',
                        ],
                        [
                            'name' => 'BPI112 H-Style Shoulder Harness',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI112_H-Style_Shoulder_Harness_2021.2-2.pdf',
                        ],
                        [
                            'name' => 'BPI086 Chest Belt',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI086_Chest_Belt_2021.12-1.pdf',
                        ],
                        [
                            'name' => 'BPI100 Monoflex',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI100_Monoflex_2021.7-3.pdf',
                        ],

                    ],
                    'Bath Belt Instructions' => [
                        [
                            'name' => 'BPI085 Aeromesh Rapid-Dry Bath Belt,Two-Piece',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI085_Aeromesh_Rapid-Dry_Bath_Belt_Two-Piece_2021.10-1.pdf',
                        ],
                        [
                            'name' => 'BPI094 Aeromesh Rapid-Dry Bath Belt,One-Piece',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI094_Aeromesh_Rapid-Dry_Bath_Belt_One-Piece_2021.8-2.pdf',
                        ],
                        [
                            'name' => 'BPI102 Shower Chair Calf Support',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI102_Shower_Chair_Calf_Support_2021.3-2.pdf',
                        ],

                    ],
                    'Hardware Instructions'=>[
                        [
                            'name' => 'BPI009 Grommet Straps',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI009_Grommet_Straps_2021.2-1.pdf',
                        ],
                        [
                            'name' => 'BPI088 Seat Mounting Bracket Kit',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI088_Seat_Mounting_Bracket_Kit_2021.2-1.pdf',
                        ],
                        [
                            'name' => 'BPI104 Shoulder Harness Strap Guides',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI104_Shoulder_Harness_Strap_Guides_2021.4-1.pdf',
                        ],
                        [
                            'name' => 'BPI109',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI109_2020.1-1.pdf',
                        ],
                        [
                            'name' => 'BPI110',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI110_2020.1-2.pdf',
                        ],
                        [
                            'name' => 'BPI115',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI115_2022.1-1.pdf',
                        ],
                        [
                            'name' => 'BPI098',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI098_2021.8-2.pdf',
                        ],
                        [
                            'name' => 'BPI107',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI107_2020.3-1.pdf',
                        ],
                        [
                            'name' => 'BPI108',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI108_2020.2-1.pdf',
                        ],
                        [
                            'name' => 'BPI111',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI111_2020.1-1.pdf',
                        ],
                        [
                            'name' => 'BPI113',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI113_2021.1-1.pdf',
                        ],
                        [
                            'name' => 'BPI114',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI114_2021.1-2.pdf',
                        ],
                        [
                            'name' => 'D20-0806-01 A',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D20-0806-01_A-1.pdf',
                        ],
                    ],
                    'Pelvic Instructions'=>[
                        [
                            'name' => 'BPI048 Leg Harness',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI048_Leg_Harness_2021.10-1.pdf',
                        ],
                        [
                            'name' => 'BPI061 Buckle Security Cover',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI061_Buckle_Security_Cover_2021.9-4.pdf',
                        ],
                        [
                            'name' => 'BPI091 Push Button Buckle Covers',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI091_Push_Button_Buckle_Covers_2021.8-1.pdf',
                        ],
                        [
                            'name' => 'BPI092 Evoflex',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI092_Evoflex_2021.14-2.pdf',
                        ],
                        [
                            'name' => 'BPI005',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPI005_2022.13-2.pdf',
                        ]
                    ],
                ],
                'Technical Bulletins' => [
                    'Specialty Product Bulletins' => [
                        [
                            'name' => 'D11-0111-01 Modification to Invacare Backrests',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0111-01_Modification_to_Invacare_Backrests.pdf',
                        ],
                        [
                            'name' => 'D11-0908-30 Washing Instruction',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0908-30_Washing_Instruction-1.pdf',
                        ],
                        [
                            'name' => 'D16-0129-01 BMR-42',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D16-0129-01_BMR-42-5.pdf',
                        ],
                        [
                            'name' => 'D16-0518-30 Barcode and Packaging Label Overview',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D16-0518-30_Barcode_and_Packaging_Label_Overview-1.pdf',
                        ],
                        [
                            'name' => 'D16-1123-30 Standard Packaging Overview',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D16-1123-30_Standard_Packaging_Overview-1.pdf',
                        ],
                    ],
                    'Technical Bulletin Archive' => [
                        [
                            'name' => 'D13-0417-30 SH-PivotFit Front-Pull Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D13-0417-30_SH_-__PivotFit_Front-Pull_Specs.pdf',
                        ],
                        [
                            'name' => 'D13-0424-30 SH-PivotFit Rear-Pull Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D13-0424-30_SH_-__PivotFit_Rear-Pull_Specs-1.pdf',
                        ],
                        [
                            'name' => 'D11-0824-30 SH-Trimline Rear-Pull Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0824-30_SH-_Trimline_-_Rear-Pull_Specs.pdf',
                        ],
                        [
                            'name' => 'D11-0824-31 SH-Trimline Front-Pull Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0824-31_SH-_Trimline_-_Front-Pull_Specs.pdf',
                        ],
                        [
                            'name' => 'D11-0825-30 Stayflex Rear-Pull Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0825-30_Stayflex_Rear-Pull_Specs.pdf',
                        ],
                        [
                            'name' => 'D11-0825-31 Stayflex Front-Pull Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0825-31_Stayflex_Front-Pull_Specs.pdf',
                        ],
                        [
                            'name' => 'D11-0831-30 Stayflex XS Rear-Pull Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0831-30_Stayflex_XS_Rear-Pull_Specs.pdf',
                        ],
                        [
                            'name' => 'D11-0831-31 Stayflex XS Front-Pull Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0831-31_Stayflex_XS_Front-Pull_Specs.pdf',
                        ],
                    ],
                    'Power Chair Bulletins' => [
                        [
                            'name' => 'D11-1111-20 Joystick Mounting Adapter Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-1111-20_Joystick_Mounting_Adapter_Specs-1.pdf',
                        ],
                        [
                            'name' => 'D12-0203-30 Joystick Compatibility Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D12-0203-30_Joystick_Compatibility_Specs.pdf',
                        ],
                        [
                            'name' => 'D15-1001-30 Tri-Lock Modular Clamps',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D15-1001-30_Tri-Lock_Modular_Clamps-1.pdf',
                        ],
                        [
                            'name' => 'D17-0728-30 Tri-Lock Rotating Shaft & Midline Arm Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D17-0728-30_Tri-Lock_Rotating_Shaft__Midline_Arm_Specs.pdf',
                        ],
                        [
                            'name' => 'D17-0816-01 PC110 Joystick Handle',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D17-0816-01_PC110_Joystick_Handle.pdf',
                        ],
                        [
                            'name' => 'D18-0724-30 Reshaping PC101-2',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D18-0724-30_Reshaping_PC101-2-1.pdf',
                        ],
                        [
                            'name' => 'D18-0730-01 Joystick Handle Permanent',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D18-0730-01_Joystick_Handle_Permanent.pdf',
                        ],
                    ],
                    'Upper Body Bulletins' => [
                        [
                            'name' => 'D09-0729-30 Stayflex Pad Dimensions',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D09-0729-30_Stayflex_Pad_Dimensions-1.pdf',
                        ],
                        [
                            'name' => 'D11-0909-30 SH - Chest Belt Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0909-30_SH_-_Chest_Belt_Specs.pdf',
                        ],
                        [
                            'name' => 'D13-0715-30 SP - Elastic Strap Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D13-0715-30_SP_-_Elastic_Strap_Specs.pdf',
                        ],
                        [
                            'name' => 'D15-0520-30 SH - Monoflex Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D15-0520-30_SH_-_Monoflex_Specs.pdf',
                        ],
                        [
                            'name' => 'D15-0930-30 SH - Monoflex on a Sling Back Chair',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D15-0930-30_SH_-_Monoflex_on_a_Sling_Back_Chair.pdf',
                        ],
                        [
                            'name' => 'D19-0410-30 B',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D19-0410-30_B.pdf',
                        ],
                        [
                            'name' => 'D19-0411-30 B',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D19-0411-30_B.pdf',
                        ],
                        [
                            'name' => 'D19-0412-30 B',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D19-0412-30_B.pdf',
                        ],
                        [
                            'name' => 'D19-0412-31 B',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D19-0412-31_B.pdf',
                        ],
                        [
                            'name' => 'D20-1029-01 B',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D20-1029-01_B.pdf',
                        ],
                    ],
                    'Bath Belt Bulletins' => [
                        [
                            'name' => 'D09-0227-01 BB - Bath Belt Spec',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D09-0227-01_BB_-_Bath_Belt_Spec-1.pdf',
                        ],
                        [
                            'name' => 'D18-0531-01 BB - Shower Chair Calf Support',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D18-0531-01_BB_-_Shower_Chair_Calf_Support-1.pdf',
                        ],
                    ],
                    'Hardware Bulletins' => [
                        [
                            'name' => 'D07-0920-01 Cam Buckle Webbing Feeding',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D07-0920-01_Cam_Buckle_Webbing_Feeding-1.pdf',
                        ],
                        [
                            'name' => 'D09-1008-30 Permanently Bonding Buckle Security Cover',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D09-1008-30_Permanently_Bonding_Buckle_Security_Cover.pdf',
                        ],
                        [
                            'name' => 'D12-0403-30',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D12-0403-30.pdf',
                        ],
                        [
                            'name' => 'D16-0129-01 BMR-42',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D16-0129-01_BMR-42-3.pdf',
                        ],
                        [
                            'name' => 'D17-1119-01 Seat Mounting Bracket',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D17-1119-01_Seat_Mounting_Bracket.pdf',
                        ],
                    ],
                    'Lower Body Bulletin' => [
                        [
                            'name' => 'D11-0831-32 SP - Calf Strap Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0831-32_SP_-_Calf_Strap_Specs.pdf',
                        ],
                        [
                            'name' => 'D11-0831-33 SP - Calf Panel Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0831-33_SP_-_Calf_Panel_Specs.pdf',
                        ],
                        [
                            'name' => 'D18-0206-30 C',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D18-0206-30_C-1.pdf',
                        ],
                    ],
                    'Pelvic Bulletins' => [
                        [
                            'name' => 'Pelvic Bulletins',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D07-0103-01_Sub-ASIS_Pad_Sizes.pdf',
                        ],
                        [
                            'name' => 'D07-0601-01 Permobil Belt Mounting Solutions',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D07-0601-01_Permobil_Belt_Mounting_Solutions.pdf',
                        ],
                        [
                            'name' => 'D11-0425-30 LH - Leg Harness Spec',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0425-30_LH_-_Leg_Harness_Spec.pdf',
                        ],
                        [
                            'name' => 'D11-0920-30 HB - 2pt Non Padded',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0920-30_HB_-_2pt_Non_Padded.pdf',
                        ],
                        [
                            'name' => 'D11-0920-34 E',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-0920-34_E.pdf',
                        ],
                        [
                            'name' => 'D11-1006-30 EB - Evoflex Technical Bulletin',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-1006-30_EB_-_Evoflex_Technical_Bulletin.pdf',
                        ],
                        [
                            'name' => 'D11-1207-30 SB - Pivot Mount Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D11-1207-30_SB_-_Pivot_Mount_Specs.pdf',
                        ],
                        [
                            'name' => 'D15-0210-30 HB - 2pt Ctr-Pull Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D15-0210-30_HB_-_2pt_Ctr-Pull_Specs.pdf',
                        ],
                        [
                            'name' => 'D15-0210-31 HB - 4pt Ctr-Pull Specs',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D15-0210-31_HB_-_4pt_Ctr-Pull_Specs.pdf',
                        ],
                        [
                            'name' => 'D15-0210-32 HB - 2pt Dual-Pull',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D15-0210-32_HB_-_2pt_Dual-Pull.pdf',
                        ],
                        [
                            'name' => 'D15-0212-30 Advanced Measuring',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D15-0212-30_Advanced_Measuring.pdf',
                        ],
                        [
                            'name' => 'D16-1116-30 HB - 4pt Dual-Pull',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D16-1116-30_HB_-_4pt_Dual-Pull.pdf',
                        ],
                        [
                            'name' => 'D16-1116-31 HB - 2pt Rear-Pull',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D16-1116-31_HB_-_2pt_Rear-Pull.pdf',
                        ],
                        [
                            'name' => 'D16-1116-32 HB - 4pt Rear-Pull',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D16-1116-32_HB_-_4pt_Rear-Pull.pdf',
                        ],
                        [
                            'name' => 'D20-0225-01 revC',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D20-0225-01_revC.pdf',
                        ],
                        [
                            'name' => 'D21-0721-01 B',
                            'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/D21-0721-01_B.pdf',
                        ],
                    ]
                ]
            ];
    }

    private function getMarketingCollateral()
    {
        return
            [
                'Tradeshow & Event Graphics' => [
                    [
                        'name' => 'Universal Top Strap Display FRONT Sign v2',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Universal_Top_Strap_Display_FRONT_Sign_v2_Folder-1.zip',
                    ],
                    [
                        'name' => 'Universal Top Strap Display FRONT Sign v2',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Universal_Top_Strap_Display_FRONT_Sign_v2_Folder.zip',
                    ],
                    [
                        'name' => 'Universal Top Strap Display BACK Sign v6',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Universal_Top_Strap_Display_BACK_Sign_v6_Folder.zip',
                    ],
                    [
                        'name' => 'BMM803 Photo Montage Banner V1',
                        'url' => '/',
                    ],
                    [
                        'name' => 'BMM067 Midline Taple Top Sign',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM067_Midline_Taple_Top_Sign.zip',
                    ],
                    [
                        'name' => 'BMM098 Aeromesh sign - text only',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM098_Aeromesh_sign_-_text_only.zip',
                    ],
                    [
                        'name' => 'BMM101 Chest Belt Display Sign',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM101_Chest_Belt_Display_Sign.zip',
                    ],
                    [
                        'name' => 'BMM060 ToddBooth-DesignFiles',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM060_ToddBooth-DesignFiles.zip',
                    ],
                    [
                        'name' => 'BMM097 Elastic Strap Display',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM097_Elastic_Strap_Display.zip',
                    ],
                    [
                        'name' => 'BMM088 Monoflex Table Top Sign',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM088_MonoflexTableTopSign.zip',
                    ],
                    [
                        'name' => 'BMM094 Belt sizing display',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM094_Belt_sizing_display.zip',
                    ],
                    [
                        'name' => 'BMM100 Midline Display Sign',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM100_Midline_Display_Sign.zip',
                    ],
                    [
                        'name' => 'BMM095 Aeromesh display',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM095_Aeromesh_display.zip',
                    ],
                    [
                        'name' => 'BMM802 Rehacare booth',
                        'url' => '/',
                    ],

                ],
                'Advertisements' => [
                    [
                        'name' => 'BMM073 PivotFit half page ad hires',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM073_PivotFit_half_page_ad_hires.pdf',
                    ],
                    [
                        'name' => 'BMM076 Directions ad high res[1]',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM076_Directions_ad_high_res1.pdf',
                    ],
                    [
                        'name' => 'BMM076 Jordan Directions ad-high res',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM076_Jordan_Directions_ad-high_res.pdf',
                    ],
                    [
                        'name' => 'BMM093Natalie-DirectionsAd',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM093Natalie-DirectionsAd.zip',
                    ],
                    [
                        'name' => 'Bodypoint Jordan Ad HalfPgHoriz 2019-10-16',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Bodypoint_Jordan_Ad_HalfPgHoriz_2019-10-16.pdf',
                    ],
                    [
                        'name' => 'BPMM043 ToddDirectionsAd v.0.7 FINAL highres',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPMM043_ToddDirectionsAd_v.0.7_FINAL_highres.pdf',
                    ],
                    [
                        'name' => 'BMM082 Julie Directions ad',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM082_Julie_Directions_ad.zip',
                    ],
                    [
                        'name' => 'BPMM043 ToddDirectionsAd',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPMM043_ToddDirectionsAd.zip',
                    ],
                    [
                        'name' => 'BMM073 PivotFit ad',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM073_PivotFit_ad.zip',
                    ],
                    [
                        'name' => 'BMM082 JordanAd',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM082_JordanAd.zip',
                    ],
                    [
                        'name' => 'Jordan Ad V1',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Jordan_Ad_V1.zip',
                    ],

                ],
                'Branding Guidelines' => [
                    [
                        'name' => 'BPMM041 BP Design Guidelines Partners highres',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPMM041_BP_DesignGuidelines_Partners_highres.pdf',
                    ],

                ],
                'Sell Sheets' => [
                    [
                        'name' => 'Updated Harness Part Numbers for MD Series Pull Straps - Excel Doc',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Updated_Harness_Part_Numbers_for_MD_Series_Pull_Straps_-_Excel_Doc.xlsx',
                    ],
                    [
                        'name' => 'Updated Harness Part Numbers for MD Series Pull Straps 2019.3 (2)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Updated_Harness_Part_Numbers_for_MD_Series_Pull_Straps_2019.3-2.pdf',
                    ],
                    [
                        'name' => 'Updated Harness Part Numbers for MD Series Pull Straps 2019.3',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Updated_Harness_Part_Numbers_for_MD_Series_Pull_Straps_2019.3.docx',
                    ],
                    [
                        'name' => 'Seat Mounting Bracket Sell Sheet Design Package 2018.3',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Seat_Mounting_Bracket_Sell_Sheet_Design_Package_2018.3.zip',
                    ],
                    [
                        'name' => 'BMM307 Mounting Hardware Kit Sell Sheet 2021.6 Folder',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM307_Mounting_Hardware_Kit_Sell_Sheet_2021.6_Folder.zip',
                    ],
                    [
                        'name' => 'BMM311 Hardware Kit Inventory Insert 2021.5 Folder',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM311_Hardware_Kit_Inventory_Insert_2021.5_Folder.zip',
                    ],
                    [
                        'name' => 'BMM313 Aeromesh Shower Chair Calf Support 2019.2',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM313_Aeromesh_Shower_Chair_Calf_Support_2019.2.zip',
                    ],
                    [
                        'name' => 'Grooved Mushroom Joystick Handle Sell Sheet 2019.2',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Grooved_Mushroom_Joystick_Handle_Sell_Sheet_2019.2.pdf',
                    ],
                    [
                        'name' => 'Grooved Mushroom Joystick Handle Sell Sheet 2019.2',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Grooved_Mushroom_Joystick_Handle_Sell_Sheet_2019.2.zip',
                    ],
                    [
                        'name' => 'BMM313 Aeromesh Shower Chair Calf Support 2019.2',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM313_Aeromesh_Shower_Chair_Calf_Support_2019.2.pdf',
                    ],
                    [
                        'name' => 'Essentials H-Style Harness Sell Sheet 2020.1 (1)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Essentials_H-Style_Harness_Sell_Sheet_2020.1-1.zip',
                    ],
                    [
                        'name' => 'Tri-Lock Midline Sell Sheet 2021.2 Final Folder',
                        'url' => '/',
                    ],
                    [
                        'name' => 'Seat Mounting Bracket Sell Sheet BMM306 2018.3',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Seat_Mounting_Bracket_Sell_Sheet_BMM306_2018.3.pdf',
                    ],
                    [
                        'name' => 'BMM307 Mounting Hardware Kit Sell Sheet 2021.6',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM307_Mounting_Hardware_Kit_Sell_Sheet_2021.6.pdf',
                    ],
                    [
                        'name' => 'BMM319 MD Series Harness Sell Sheet 2021.6',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM319_MD_Series_Harness_Sell_Sheet_2021.6.zip',
                    ],
                    [
                        'name' => 'BMM320 Joystick Handle Sell Sheet 2019.2 (1)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM320_Joystick_Handle_Sell_Sheet_2019.2-1.pdf',
                    ],
                    [
                        'name' => 'BMM337 Essentials Hip Belt Sell Sheet 2021.3',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM337_Essentials_Hip_Belt_Sell_Sheet_2021.3.pdf',
                    ],
                    [
                        'name' => 'Essentials Hip Belt Sell Sheet -BMM337 2023.4',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Essentials_Hip_Belt_Sell_Sheet_-BMM337_2023.4-1.pdf',
                    ],
                    [
                        'name' => 'Essentials H-Style Harness Sell Sheet 2020.1',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Essentials_H-Style_Harness_Sell_Sheet_2020.1.pdf',
                    ],
                    [
                        'name' => 'BMM319 MD Series Harness Sell Sheet 2021.6',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM319_MD_Series_Harness_Sell_Sheet_2021.6.pdf',
                    ],
                    [
                        'name' => 'Universal Elastic Strap Sell Sheet 2019.3',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Universal_Elastic_Strap_Sell_Sheet_2019.3.pdf',
                    ],
                    [
                        'name' => 'Universal Elastic Strap Sell Sheet 2019.3',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Universal_Elastic_Strap_Sell_Sheet_2019.3.zip',
                    ],
                    [
                        'name' => 'BMM333 Joystick Display Sell Sheet 2020.2',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM333_Joystick_Display_Sell_Sheet_2020.2.pdf',
                    ],
                    [
                        'name' => 'BMM325 Monoflex Chest Support 2021.2 (1)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM325_Monoflex_Chest_Support_2021.2-1.zip',
                    ],
                    [
                        'name' => 'BMM303 Aeromesh Bath Products 2021.4 (2)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM303_Aeromesh_Bath_Products_2021.4-2.zip',
                    ],
                    [
                        'name' => 'BMM303 Aeromesh Bath Products 2021.4 (3)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM303_Aeromesh_Bath_Products_2021.4-3.pdf',
                    ],
                    [
                        'name' => 'BMM321 Mobility Bag Sell Sheet Folder',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM321_Mobility_Bag_Sell_Sheet_Folder.zip',
                    ],
                    [
                        'name' => 'Chest Belt Sell Sheet BMM305 2018.1 (1)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Chest_Belt_Sell_Sheet_BMM305_2018.1-1.pdf',
                    ],
                    [
                        'name' => 'BMM309 Strap Guide sell sheet 2021.5',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM309_Strap_Guide_sell_sheet_2021.5.pdf',
                    ],
                    [
                        'name' => 'BMM309 Strap Guide sell sheet 2021.5',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM309_Strap_Guide_sell_sheet_2021.5.zip',
                    ],
                    [
                        'name' => 'BMM321 Mobility Bag Sell Sheet 2019.1',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM321_Mobility_Bag_Sell_Sheet_2019.1.pdf',
                    ],
                    [
                        'name' => 'BMM325 Monoflex Chest Support 2021.2',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM325_Monoflex_Chest_Support_2021.2.zip',
                    ],
                    [
                        'name' => 'BMM325 Monoflex Chest Support 2021.2',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM325_Monoflex_Chest_Support_2021.2.pdf',
                    ],
                    [
                        'name' => 'Chest Belt Sell Sheet Design Package',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Chest_Belt_Sell_Sheet_Design_Package.zip',
                    ],
                    [
                        'name' => 'Ankle Hugger sell sheet 2020.4 (1)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Ankle_Hugger_sell_sheet_2020.4-1.zip',
                    ],
                    [
                        'name' => 'Ankle Hugger sell sheet 2020.4 (2)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Ankle_Hugger_sell_sheet_2020.4-2.pdf',
                    ],
                    [
                        'name' => 'BMM328 Evoflex Sell Sheet 2021.5 (1)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM328_Evoflex_Sell_Sheet_2021.5-1.pdf',
                    ],
                    [
                        'name' => 'Tri-Lock Midline Sell Sheet 2021.2',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Tri-Lock_Midline_Sell_Sheet_2021.2.pdf',
                    ],
                    [
                        'name' => 'BMM327 Stayflex Sell Sheet 2021.3',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM327_Stayflex_Sell_Sheet_2021.3.pdf',
                    ],
                    [
                        'name' => 'BMM327 Stayflex Sell Sheet 2021.3',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM327_Stayflex_Sell_Sheet_2021.3.zip',
                    ],
                    [
                        'name' => 'BMM326 PivotFit Sell Sheet 2021.4',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM326_PivotFit_Sell_Sheet_2021.4.zip',
                    ],
                    [
                        'name' => 'BMM326 PivotFit Sell Sheet 2021.4',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM326_PivotFit_Sell_Sheet_2021.4.pdf',
                    ],
                    [
                        'name' => 'BMM328 Evoflex Sell Sheet 2021.5',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM328_Evoflex_Sell_Sheet_2021.5.zip',
                    ],
                    [
                        'name' => 'Joystick Handle Sell Sheet (1)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Joystick_Handle_Sell_Sheet-1.zip',
                    ],

                ],
                'Brochures' => [
                    [
                        'name' => 'BMM037 Anterior Trunk Support Usage Guide 2020.4 - High Res',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM037_Anterior_Trunk_Support_Usage_Guide_2020.4_-_High_Res.pdf',
                    ],
                    [
                        'name' => 'BMM037 Anterior Trunk Support Usage Guide 2020.4 - Low Res',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM037_Anterior_Trunk_Support_Usage_Guide_2020.4_-_Low_Res.pdf',
                    ],
                    [
                        'name' => 'BMM037 Anterior Trunk Support Usage Guide 2020.4',
                        'url' => '/',
                    ],
                    [
                        'name' => 'Dynamic Arm Support Brochure BMM343 (2022.4)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Dynamic-Arm-Support-Brochure-BMM343-2022.4-1.pdf',
                    ],
                    [
                        'name' => "BMM039 Lower Body User's Guide print files",
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM039_Lower_Body_Users_Guide_print_files.zip',
                    ],
                    [
                        'name' => "BMM044 Pelvic Support Users Guide low",
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BMM039_Lower_Body_Users_Guide_print_files.zip',
                    ],
                    [
                        'name' => "Dynamic Arm Support Brochure BMM343",
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Dynamic-Arm-Support-Brochure-BMM343.zip',
                    ],
                    [
                        'name' => "Trifold Brochure (BMM347) 2024.02",
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Trifold-Brochure-BMM347-2024.02.zip',
                    ],
                    [
                        'name' => "Trifold Brochure (BMM347) 2024.02",
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Trifold-Brochure-BMM347-2024.02-1.pdf',
                    ],

                ],
                'Posters' => [
                    [
                        'name' => 'Belt Mounting Hardware Poster 2021.5 (1)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Belt_Mounting_Hardware_Poster_2021.5-1.pdf',
                    ],
                    [
                        'name' => 'Belt Mounting Hardware Poster 2021.5',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Belt_Mounting_Hardware_Poster_2021.5.zip',
                    ],
                    [
                        'name' => 'BPMM058 BarryLongPoster (1)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BPMM058_BarryLongPoster-1.zip',
                    ],

                ],
                'Catalog' => [
                    [
                        'name' => 'Catalog (product guide) BMM002 (Volume 8.4) (HI RES)',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/Catalog_product_guide_BMM002_Volume_8.4_HI_RES-1.pdf',
                    ],
                    [
                        'name' => 'Catalog (product guide) BMM002 (Volume 8.4)',
                        'url' => '/',
                    ],

                ],
            ];
    }

    private function getMediaAssets()
    {
        return
            [
                'Logo' => [
                    [
                        'name' => 'BP Logo Full Lockup Tag Below',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BP_Logo_Full_Lockup_Tag_Below.zip',
                    ],
                    [
                        'name' => 'BP Logo Full Lockup Vertical',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BP_Logo_Full_Lockup_Vertical.zip',
                    ],
                    [
                        'name' => 'ISO-RESNA Check mark and seal',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/ISO-RESNA_Check_mark_and_seal.zip',
                    ],
                    [
                        'name' => 'ISO-RESNA Check mark only',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/ISO-RESNA_Check_mark_only.zip',
                    ],
                    [
                        'name' => 'BP Logo Full Lockup',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BP_Logo_Full_Lockup.zip',
                    ],
                    [
                        'name' => 'BP Logo Symbol',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BP_Logo_Symbol.zip',
                    ],
                    [
                        'name' => 'BP Logo Symbol Tag Below',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BP_Logo_Symbol_Tag_Below.zip',
                    ],
                    [
                        'name' => 'BP Logo Symbol Tag Right',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/BP_Logo_Symbol_Tag_Right.zip',
                    ],
                    [
                        'name' => 'ISO-RESNA Full Logo',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/ISO-RESNA_Full_Logo.zip',
                    ],

                ],
                'Photo Release Form' => [
                    [
                        'name' => 'PhotoReleaseDutch-2021',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/PhotoReleaseDutch_-_2021.docx',
                    ],
                    [
                        'name' => 'PhotoReleaseEnglish-2021',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/PhotoReleaseEnglish_-_2021.docx',
                    ],
                    [
                        'name' => 'PhotoReleaseFrench-2021',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/PhotoReleaseFrench_-_2021.docx',
                    ],
                    [
                        'name' => 'PhotoReleaseGerman-2021',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/PhotoReleaseGerman_-_2021.docx',
                    ],
                    [
                        'name' => 'PhotoReleasePortuguese-2021',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/PhotoReleasePortuguese_-_2021.docx',
                    ],
                    [
                        'name' => 'PhotoReleaseSpanish-2021',
                        'url' => 'https://bodypoint.com/wp-content/uploads/2024/07/PhotoReleaseSpanish_-_2021.docx',
                    ],

                ],
            ];
    }

    public function getActiveCampaigns(){
        return [
            ['image' =>'https://bodypoint.com/wp-content/uploads/2024/07/Bath-Postcard-Back.png'],
            ['image' =>'https://bodypoint.com/wp-content/uploads/2024/07/Bath-Postcard-Front.png'],
        ];
    }

    public function vault(Request $request)
    {   
        $customer_id = getCustomerId();
        $frequently_user_files = $this->getFrequentlyUserFiles();
        $newly_added =  $this->getNewlyAdded();
        $media_assets = $this->getMediaAssets();
        $marketing_collateral = $this->getMarketingCollateral();
        $product_and_technical = $this->getProductAndTechnical();
        $pricing_guide = $this->getPricingGuide();
        $presentations = $this->getPresentations();
        $active_campaigns = $this->getActiveCampaigns();
        
        if ($customer_id) {
            $customer = AssociateCustomer::where([
                ['user_id', Auth::id()],
                ['customer_id', $customer_id]
            ])->first();
        
            $rolesToCheck = ['VA', 'WC', 'WI', 'WM', 'WR', 'WL'];
            $url = 'GetCustomerDetails/' . $customer_id;
            $get_customer_details = SysproService::getCustomerDetails($url);
            if($get_customer_details){
                $customerType = $get_customer_details['CustomerType'];
            }
            // if ($customer && $customer->role && in_array($customer->role, $rolesToCheck)) {
            //     $pricing_guide = array_values(array_filter($this->getPricingGuide(), function ($item) {
            //         return $item['name'] !== 'Dealer Price List';
            //     }));
            // }
            
            // if (Auth::user()->hasAnyRole(['VA', 'WC', 'WI', 'WM', 'WR', 'WL'])) {
            //     $pricing_guide = array_values(array_filter($this->getPricingGuide(), function ($item) {
            //         return $item['name'] !== 'Dealer Price List';
            //     }));
            // }

            switch ($customerType) {
                case 'Domestic':
                    
                    $pricing_guide = array_filter($pricing_guide, function ($item) {
                        return in_array($item['name'], [
                            'Americas',
                            'Dealer Price List',
                            'Retail Price List',
                        ]);
                    });
                    break;
        
                case 'International':
                   
                    $pricing_guide = array_filter($pricing_guide, function ($item) {
                        return in_array($item['name'], [
                            'International',
                            'Retail Price List',
                        ]);
                    });
                    break;
        
                case 'Manufacturer':
                    
                    $pricing_guide = [];
                    break;
        
                default:
                   
                    $pricing_guide = [];
                    break;
            }
        }
        $pricing_guide = array_values($pricing_guide);
        $data = [
            'frequently_user_files' => $frequently_user_files,
            'newly_added' => $newly_added,
            'media_assets' => $media_assets,
            'marketing_collateral' => $marketing_collateral,
            'product_and_technical' => $product_and_technical,
            'pricing_guide' => $pricing_guide,
            'presentations' => $presentations,
            'active_campaigns' => $active_campaigns,
        ];
        return view('vault', $data);
    }

    public function postVault(Request $request)
    {
        try {
            
            $data = $request->all(); 
    
            Mail::to('support@bodypoint.com')->send(new VaultMail($data));
    
            return redirect()->back()->with('success', 'Email sent successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}
