import {
    AlertDialog,
    AlertDialogBody,
    AlertDialogContent,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogOverlay,
    Box,
    Button,
    Center,
    Image,
    Spacer,
    Table,
    TableContainer,
    Tbody,
    Td,
    Text,
    Th,
    Thead,
    Tr,
    useDisclosure,
    useToast,
} from '@chakra-ui/react';
import {useEffect, useRef, useState } from 'react';
import axios from 'axios';
import {  Link  } from '@inertiajs/react';
import Header from '../components/header.jsx';
import { getMainImage} from '../utils/hotelUtils.js';
import { ArrowBackIcon, ArrowForwardIcon, DeleteIcon } from '@chakra-ui/icons';
export default function Index() {


    //toast bouton suppression d'hotel
    const { isOpen, onOpen, onClose } = useDisclosure()
    const cancelRef = useRef();
    const [selectedHotel,setSelectedHotel]=useState(null)
    const toast = useToast()


    //suivre l'état des hotels
    const [hotels,setHotels] = useState([]);
    const [initialHotels,setInitialHotels]=useState([]);
    const [pagination,setPagination]=useState({});
    const [page, setPage]=useState(1);
    const [loading,setLoading]=useState(false);


    //recherche
    const [searchQuery,setSearchQuery] =useState('');


    //initialisation des données sur la page au lancement
    useEffect(() => {
        fetchHotels(page);
    }, []);




    //récupérer la page choisie par l'utilisateur (pagination)
    const fetchHotels = async(page=1)=>{
        const response=await axios.get(`http://localhost:8000/api/hotels?page=${page}`);
        setHotels(response.data.data)
        setPagination(response.data.last_page)
        setPage(page)
    };

    //gestion de la barre de recherche et actualisation des données de pagination
    const searchBar =async(query)=>{
        setSearchQuery(query)

        //si le champ de recherche est vide revenir à la page 1
        if(query.trim() ===""){
            fetchHotels(1);
            return;
        }

        const response=await axios.get(`http://localhost:8000/api/hotels`,{
            params: {q:query}
        });

        setHotels(response.data.data)
        setPagination(response.data.last_page)
        setPage(response.data.current_page)
    }


    const handlePageChange=(pageNumber)=>{
        //controle de l index de page pour ne pas déborder la pagination
        if(pageNumber ===0 ) pageNumber=1;
        if(pageNumber>pagination-1) pageNumber= pagination
        fetchHotels(pageNumber)
        window.scrollTo({top:0,behavior:'smooth'});
    }


    //si il n y a pas d'hôtel
    if(!pagination){
        return <Text>Aucune donnée disponible</Text>;
    }


    //gestion de la suppression d'un hôtel côté front
    const deleteHotel = async (hotelId)=> {
        try{

            setHotels(prevHotels=>prevHotels.filter(hotel=>hotel.id !==hotelId));

            const response=await axios.delete(`http://localhost:8000/api/hotels/${hotelId}`);

            /* toast de confirmation de suppression*/
            toast({
                title: response.data,
                status: 'success',
                position:'top-right',
                isClosable: true,
            })
            fetchHotels(page)

        }catch(error){
            toast({
                title:`Erreur lors de la suppression de l'hôtel`,
                status: 'error',
                position:'top-right',
                isClosable: true,
            })
        }
    }



    return (
        <Box>
            {/* Header */}
            <Header showSearch={true} searchQuery={searchQuery} onSearchChange={searchBar} />
            {/* Fin Header */}

            {/*Pagination*/}
            <Center>
                <Button m={10}
                        onClick={() => handlePageChange(page - 1)}
                        isDisabled={page<=1}
                 >
                    <ArrowBackIcon/>
                    Précédent
                </Button>
                <Text mr={8}>{page}</Text>
                <Button
                    onClick={() => handlePageChange(page + 1)}
                    isDisabled={page>=pagination}
                >
                    Suivant <ArrowForwardIcon />
                </Button>
            </Center>
            {/*Fin Pagination */}
            <Spacer/>

            {/* Bouton de création d'hôtel*/}
            <Center>
                <Link href={`/hotels/new`}  prefetch>
                    <Button w="200px" colorScheme="blue">
                        Créer un hôtel
                    </Button>
                </Link>
            </Center>
            {/* Fin Bouton de création d'hôtel*/}

            {/*Table d'affichage d'hôtels */}
            <Box>
                <TableContainer>
                    <Table size="lg">
                        <Thead>
                            <Tr>
                                <Th>
                                    <Center>Image</Center>
                                </Th>
                                <Th>
                                    <Center>Name</Center>
                                </Th>
                                <Th>
                                    <Center>City</Center>
                                </Th>
                                <Th>
                                    <Center>Description</Center>
                                </Th>
                                <Th>
                                    <Center>Capacité Maximale</Center>
                                </Th>
                                <Th>
                                    <Center>Hotel</Center>
                                </Th>
                                <Th>
                                    <Center>Images</Center>
                                </Th>
                            </Tr>
                        </Thead>
                        <Tbody>
                            {hotels.map((hotel) => (
                                <Tr key={hotel.id} >
                                    <Td>
                                        <Link href={`/hotels/${hotel.id}`} prefetch>
                                            <Button m={5}>Detail</Button>
                                        </Link>
                                        {
                                            (() => {//afficher l'image que quand l'hotel a déja une image principale
                                                const firstImage = getMainImage(hotel);
                                                //afficher que les images qui sont affichables
                                                return firstImage?.id && firstImage?.displayable ? (
                                                    <Image
                                                        borderRadius="xl"
                                                        boxSize="100px"
                                                        objectFit="cover"
                                                        src={`http://localhost:8000/storage/${firstImage?.filepath}`}
                                                        alt="image"
                                                        loading="lazy"
                                                    />
                                                ) : (
                                                    <Text fontSize={20}>Pas d'image</Text>
                                                );
                                            })()
                                        }


                                    </Td>
                                    <Td>{hotel.name}</Td>
                                    <Td>{hotel.city}</Td>
                                    <Td>
                                        <Box w="200px" overflow="hidden">
                                            <Text isTruncated noOfLines={[1, 2, 3]} whiteSpace="wrap" maxW="200px">
                                                {hotel.description}
                                            </Text>
                                        </Box>
                                    </Td>
                                    <Td>{hotel.max_capacity}</Td>
                                    <Td>
                                        <Box display="grid" gridTemplateColumns="repeat(2, 1fr)" gap="8px">
                                            <Link href={`/hotels/${hotel.id}/update`} prefetch>
                                                <Button w="100px" colorScheme="orange">
                                                    Modifier
                                                </Button>
                                            </Link>

                                            <Button
                                                w="100px"
                                                colorScheme="red"
                                                onClick={() => {
                                                    setSelectedHotel(hotel.id);
                                                    onOpen();
                                                }}
                                            >
                                                <DeleteIcon mr={1}/>
                                                Supprimer
                                            </Button>

                                            <Link href={`/hotels/${hotel.id}`}  prefetch>
                                                <Button w="100px">Detail</Button>
                                            </Link>
                                        </Box>
                                    </Td>

                                    <Td>
                                        <Box display="grid" gridTemplateColumns="repeat(2, 1fr)" gap="8px">

                                            <Link href={`/hotels/${hotel.id}/picture/`} method="get" as="button"  prefetch={['mount', 'hover']}>
                                                <Button w="100px" colorScheme="yellow">+ Créer</Button>
                                            </Link>

                                            {
                                                (() => {//afficher le bouton modifier que quand l'hotel a déja une image principale
                                                    const firstImage = getMainImage(hotel);
                                                    return firstImage?.id  ? (
                                                        <Link href={`/hotels/${hotel.id}/picture/${firstImage.id}`} method="get" as="button" prefetch>
                                                            <Button w="100px" colorScheme="green">+Modifier</Button>
                                                        </Link>
                                                    ) : (
                                                        <p></p>
                                                    );
                                                })()
                                            }

                                            <Link href={`/hotels/${hotel.id}/pictures`} method="get" as="button" prefetch>
                                                <Button colorScheme="purple" >ordonner</Button>
                                            </Link>

                                        </Box>
                                    </Td>
                                </Tr>
                            ))}
                        </Tbody>
                    </Table>
                </TableContainer>
            </Box>
            {/* Fin  Table d'affichage d'hôtel */}

            {/* Boite de dialogue de confirmation de suppression d un hôtel */}
            <AlertDialog isOpen={isOpen} leastDestructiveRef={cancelRef} onClose={onClose}>
                <AlertDialogOverlay>
                    <AlertDialogContent>
                        <AlertDialogHeader fontSize="lg" fontWeight="bold">
                            Supprimer l'hôtel
                        </AlertDialogHeader>

                        <AlertDialogBody>Voulez-vous vraiment supprimer cet hôtel??</AlertDialogBody>

                        <AlertDialogFooter>
                            <Button ref={cancelRef} onClick={onClose}>
                                Annuler
                            </Button>
                            <Button
                                colorScheme="red"
                                ml={3}
                                onClick={() => {
                                    deleteHotel(selectedHotel);
                                    onClose();
                                }}
                            >
                                Supprimer
                            </Button>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialogOverlay>
            </AlertDialog>
            {/* fin boite de dialogue de suppression d'hotel*/}
        </Box>
    );
}
