<?php  

namespace App\Http\Controllers;  

use Illuminate\Http\Request;  

class BuatIRSController extends Controller  
{  
    // Display the form for creating an IRS entry  
    public function index()  
    {  
        // Here you might want to fetch data needed for the IRS form.  
        return view('buatirs'); // Make sure this view exists.  
    }  

    // Store the IRS entry  
    public function store(Request $request)  
    {  
        // Validate the request  
        $validatedData = $request->validate([  
            'course' => 'required|string|max:255',  
            'semester' => 'required|integer',  
            'credit_hours' => 'required|integer|min:1',  
        ]);  

        // Logic to store the IRS data  
        // Example: IRS::create($validatedData);  
        
        // Redirect after storing  
        return redirect()->route('buat.irs')->with('success', 'IRS successfully created.');  
    }  
}