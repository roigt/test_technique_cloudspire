import axios from 'axios';
import HotelForm from '../components/hotelForm.jsx';
import Header from '../components/header.jsx';

export default function Update({hotel}){
    const handleSubmit=async(values)=>{
        return await axios.put(`http://localhost:8000/api/hotels/${hotel.id}`,values);
    }
    return(
          <>
              <Header
                  showSearch={false}
              />
              <HotelForm title="Modifier l'hôtel"  initialValues={hotel} onSubmit={handleSubmit}/>
          </>
        )
}
