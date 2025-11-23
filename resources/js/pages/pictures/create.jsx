import HotelPictureForm from '@/pages/components/hotelPictureForm.jsx';
import axios from 'axios';
import Header from '@/pages/components/header.jsx';
import { Box } from '@chakra-ui/react';

export default function Create({hotelId,nextPosition}) {
    const handleSubmit=async (formData)=>{
        await axios.post(`/api/hotels/${hotelId}/pictures/`, formData, {
            headers:{ 'Content-Type': 'multipart/form-data' }
        });
    }

    return (
        <Box>
            <Header
                showSearch={false}
            />
            <HotelPictureForm
                onSubmit={handleSubmit}
                title="Ajouter une image à l'hôtel"
                nextPos={nextPosition}
            />
        </Box>

    )
}
