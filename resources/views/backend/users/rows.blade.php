@forelse ($data as $user)
                   <tr>
                   <td>{{ $loop->index+1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if(!empty($user->getRoleNames()))
                            <details>
                                <summary style="cursor:pointer; font-weight:600; color:#0d6efd;">
                                    View {{ count($user->getRoleNames()) }} Roles
                                </summary>

                                <div style="margin-top:8px;">
                                    @foreach($user->getRoleNames() as $v)
                                    <ul>
                                        <li> {{ $v }}</li>
                                    </ul>
                                    @endforeach
                                </div>
                            </details>
                            @endif
                        </td>
                        <td>
                            <a class="btn  btn-sm" style="background-color:#ff5733;" href="{{ route('users.show',$user->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
         
                            @can('user-delete')
                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                            @endcan

                            
                        </td>
                    </tr>
                   @empty
                   <tr><td colspan="7" class="text-center text-muted">No User available</td></tr>
                   @endforelse