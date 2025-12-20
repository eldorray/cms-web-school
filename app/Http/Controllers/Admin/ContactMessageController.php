<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = ContactMessage::forSchool(session('school_id'))
            ->when($request->status === 'unread', fn($q) => $q->unread())
            ->when($request->status === 'read', fn($q) => $q->read())
            ->latest()
            ->paginate(15);

        $unreadCount = ContactMessage::forSchool(session('school_id'))->unread()->count();

        return view('admin.contacts.index', compact('messages', 'unreadCount'));
    }

    public function show(ContactMessage $contact)
    {
        $this->authorizeSchool($contact);
        $contact->markAsRead();

        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(ContactMessage $contact)
    {
        $this->authorizeSchool($contact);
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('status', 'Pesan berhasil dihapus.');
    }

    public function toggleRead(ContactMessage $contact)
    {
        $this->authorizeSchool($contact);

        if ($contact->is_read) {
            $contact->markAsUnread();
        } else {
            $contact->markAsRead();
        }

        return back();
    }

    protected function authorizeSchool($model): void
    {
        if ($model->school_id !== session('school_id')) {
            abort(403, 'Unauthorized');
        }
    }
}
