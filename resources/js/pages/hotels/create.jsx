
import axios from 'axios';
import HotelForm from '../components/hotelForm.jsx';
import Header from '../components/header.jsx';

export default function Create(){
    const handleSubmit=async(values)=>{
        return await axios.post(`http://localhost:8000/api/hotels/`,values);
    }
    return (
       <>
           <Header
               showSearch={false}
           />
           <HotelForm title="Créer un hôtel"   onSubmit={handleSubmit}/>
       </>
    )
}
