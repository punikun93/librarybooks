
<li>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
            Logout      
  </button>
    </form>
</li>
