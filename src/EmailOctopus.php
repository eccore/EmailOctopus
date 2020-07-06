<?php
/*
 * This file is part of the ideneal/emailoctopus library
 *
 * (c) Daniele Pedone <ideneal.ztl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ideneal\EmailOctopus;


use Ideneal\EmailOctopus\Entity\Campaign;
use Ideneal\EmailOctopus\Entity\Contact;
use Ideneal\EmailOctopus\Entity\MailingList;
use Ideneal\EmailOctopus\Entity\MailingListField;
use Ideneal\EmailOctopus\Http\ApiClient;
use Ideneal\EmailOctopus\Serializer\CampaignSerializer;
use Ideneal\EmailOctopus\Serializer\ContactSerializer;
use Ideneal\EmailOctopus\Serializer\MailingListFieldSerializer;
use Ideneal\EmailOctopus\Serializer\MailingListSerializer;


/**
 * Class EmailOctopus
 *
 * @package Ideneal\EmailOctopus
 */
class EmailOctopus
{
    /**
     * @var ApiClient
     */
    private $client;

    /**
     * EmailOctopus constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->client = new ApiClient($apiKey);
    }

    /**
     * Returns all mailing lists.
     *
     * @param int $limit
     * @param int $page
     *
     * @return MailingList[]
     */
    public function getMailingLists(int $limit = 100, int $page = 1): array
    {
        $response = $this->client->get('lists', [
            'limit' => $limit,
            'page'  => $page,
        ]);
        return MailingListSerializer::deserialize($response);
    }

    /**
     * Returns the mailing list.
     *
     * @param string $id
     *
     * @return MailingList
     */
    public function getMailingList(string $id): MailingList
    {
        $response = $this->client->get('lists/' . $id);
        return MailingListSerializer::deserialize($response);
    }

    /**
     * Creates a mailing list.
     *
     * @param MailingList $list
     *
     * @return MailingList
     */
    public function createMailingList(MailingList $list): MailingList
    {
        $response = $this->client->post('lists', MailingListSerializer::serialize($list));
        return MailingListSerializer::deserialize($response);
    }

    /**
     * Updates a mailing list.
     *
     * @param MailingList $list
     *
     * @return MailingList
     */
    public function updateMailingList(MailingList $list): MailingList
    {
        $response = $this->client->put('lists/' . $list->getId(), MailingListSerializer::serialize($list));
        return MailingListSerializer::deserialize($response);
    }

    /**
     * Deletes a mailing list.
     *
     * @param MailingList $list
     */
    public function deleteMailingList(MailingList $list): void
    {
        $this->client->delete('lists/' . $list->getId());
    }

    /**
     * Creates a mailing list field.
     *
     * @param MailingListField $field
     * @param MailingList      $list
     *
     * @return MailingListField
     */
    public function createMailingListField(MailingListField $field, MailingList $list): MailingListField
    {
        $response = $this->client->post('lists/' . $list->getId() . '/fields', MailingListFieldSerializer::serialize($field));
        return MailingListFieldSerializer::deserialize($response);
    }

    /**
     * Updates a mailing list field.
     *
     * @param MailingListField $field
     * @param MailingList      $list
     *
     * @return MailingListField
     */
    public function updateMailingListField(MailingListField $field, MailingList $list): MailingListField
    {
        $response = $this->client->post('lists/' . $list->getId() . '/fields/' . $field->getTag(), MailingListFieldSerializer::serialize($field));
        return MailingListFieldSerializer::deserialize($response);
    }

    /**
     * Deletes a mailing list field.
     *
     * @param MailingListField $field
     * @param MailingList      $list
     */
    public function deleteMailingListField(MailingListField $field, MailingList $list): void
    {
        $this->client->delete('lists/' . $list->getId() . '/fields/' . $field->getTag());
    }

    /**
     * Returns all contact of a mailing list.
     *
     * @param MailingList $list
     * @param int         $limit
     * @param int         $page
     *
     * @return Contact[]
     */
    public function getContactsByMailingList(MailingList $list, int $limit = 100, int $page = 1): array
    {
        $response = $this->client->get('lists/' . $list->getId() . '/contacts', [
            'limit' => $limit,
            'page'  => $page,
        ]);
        return ContactSerializer::deserialize($response);
    }

    /**
     * Returns a contact of a mailing list.
     *
     * @param MailingList $list
     * @param string      $contactId
     *
     * @return Contact
     */
    public function getContactByMailingList(MailingList $list, string $contactId): Contact
    {
        $response = $this->client->get('lists/' . $list->getId() . '/contacts/' . $contactId);
        return ContactSerializer::deserialize($response);
    }

    /**
     * Creates a contact of a mailing list.
     *
     * @param Contact     $contact
     * @param MailingList $list
     *
     * @return Contact
     */
    public function createContact(Contact $contact, MailingList $list): Contact
    {
        $response = $this->client->post('lists/' . $list->getId() . '/contacts', ContactSerializer::serialize($contact));
        return ContactSerializer::deserialize($response);
    }

    /**
     * Deletes a contact of a mailing list.
     *
     * @param Contact     $contact
     * @param MailingList $list
     */
    public function deleteContact(Contact $contact, MailingList $list)
    {
        $this->client->delete('lists/' . $list->getId() . '/contacts/' . $contact->getId());
    }

    /**
     * Returns all campaigns.
     *
     * @param int $limit
     * @param int $page
     *
     * @return Campaign[]
     */
    public function getCampaigns(int $limit = 100, int $page = 1): array
    {
        $response = $this->client->get('campaigns', [
            'limit' => $limit,
            'page'  => $page,
        ]);
        return CampaignSerializer::deserialize($response);
    }

    /**
     * Returns a campaign.
     *
     * @param string $id
     *
     * @return Campaign
     */
    public function getCampaign(string $id): Campaign
    {
        $response = $this->client->get('campaigns/' . $id);
        return CampaignSerializer::deserialize($response);
    }
}