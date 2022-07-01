import { useForm } from '@inertiajs/inertia-react'
import { useEffect } from 'react';
import React from 'react'

export default function CreateRole({close,model,isModel = false}) {
    

    const {data, setData, post, put, reset, errors} = useForm({ name: '', });
    const onChange = (e) => setData({ ...data, [e.target.id]: e.target.value });
 
    useEffect(() => {
        setData({...data,
            name: model?.name
        });
    }, [model,isModel]);


    const onSubmit = (e) => {
        e.preventDefault();
        if(isModel){
            updateRole()
            return;
        }
        createRole()
    }

    function createRole()
    {
        post(route('roles.store'), {
            data, 
            onSuccess: () => {
                reset(),
                close()
            }
        });
    }

    function updateRole()
    {
        put(route('roles.update', model.id), {
            data, 
            onSuccess: () => {
                reset(),
                close()
            }, 
        });
    }

    return (
        <>
            <form onSubmit={onSubmit}>
                <div className="modal-body">
                        <div className="form-group">
                            <label htmlFor="name" className="col-form-label">Name:</label>
                            <input type="text" className="form-control" name='name' id="name" value={data.name} onChange={onChange} />
                            {errors && <div className='text-danger mt-1'>{errors.name}</div>}
                        </div>
                </div>
                <div className="modal-footer">
                    <button type="button" className="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" className="btn bg-gradient-primary">Save</button>
                </div>
            </form>
        </>

    )
}
