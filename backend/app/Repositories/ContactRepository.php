<?php

namespace App\Repositories;

use App\Classes\JsonResponseFormat;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class ContactRepository extends JsonResponseFormat
{

    /**
     * handles contact index
     *
     * @param array $data
     * @return array
     */
    public function index(array $request): array
    {
        $contacts = Contact::where('user_id', auth()->user()->id)->when(isset($request['search']), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request['search'] . '%')
                    ->orWhere('company', 'like', '%' . $request['search'] . '%')
                    ->orWhere('phone', 'like', '%' . $request['search'] . '%')
                    ->orWhere('email', 'like', '%' . $request['search'] . '%');
            });
        })
            ->with(['user'])
            ->paginate($request['show'] ?? 7, ['*'], 'page', $request['page'] ?? 1);

        return [
            'message' => 'These are the data.',
            'body' => $contacts->items(),
            'per_page' => $contacts->perPage(),
            'current_page' => $contacts->currentPage(),
            'last_page' => $contacts->lastPage(),
            'from' => $contacts->firstItem(),
            'to' => $contacts->lastItem(),
            'total' => $contacts->total(),

        ];
    }

    /**
     * handles contact index
     *
     * @param array $data
     * @return array
     */
    public function store(array $data): array
    {
        try {
            $contact = Contact::create($data);

            return [
                'message' => 'Contact Successfully Added.',
                'body' => $contact
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * handles contact index
     *
     * @param array $data
     * @return array
     */
    public function update(array $data, $id): array
    {
        DB::beginTransaction();
        try {
            $contact = Contact::find($id);
            $contact->update($data);

            DB::commit();
            return [
                'message' => 'Contact Successfully Updated.',
                'body' => $contact
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => $e->getMessage()
            ];
        }
        return [];
    }

    /**
     * handles contact index
     *
     * @param array $data
     * @return array
     */
    public function delete(array $data, $id): array
    {
        DB::beginTransaction();
        try {
            $contact = Contact::find($id);
            $contact->delete();


            DB::commit();
            return ['message' => 'Contact Successfully Deleted.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
